<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    /** @use HasFactory<\Database\Factories\RegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workshop_id',
        'amount',
        'order_id',
        'snap_token',
        'payment_status',
        'paid_at',
        'ticket_code',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'payment_status' => 'string',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class);
    }
}
