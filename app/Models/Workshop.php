<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workshop extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'speaker',
        'venue',
        'starts_at',
        'ends_at',
        'price',
        'quota',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at'   => 'datetime',
            'price'     => 'integer',
            'quota'     => 'integer',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Kuota terpakai = paid + pending yang dibuat < 24 jam lalu (PRD 7.4)
    public function seatsTaken(): int
    {
        return $this->registrations()
            ->where(function ($q) {
                $q->where('payment_status', 'paid')
                  ->orWhere(function ($q) {
                      $q->where('payment_status', 'pending')
                        ->where('created_at', '>=', now()->subDay());
                  });
            })
            ->count();
    }

    public function seatsLeft(): int
    {
        return max(0, $this->quota - $this->seatsTaken());
    }

    // Aksesor agar view memakai $workshop->seats_left baik untuk data dummy maupun Eloquent.
    public function getSeatsLeftAttribute(): int
    {
        return $this->seatsLeft();
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('workshops/'.$this->image) : null;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>', now());
    }

    public function hasStarted(): bool
    {
        return $this->starts_at->isPast();
    }
}