<?php

namespace Database\Seeders;

use App\Models\Registration;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $peserta = User::where('role', 'peserta')->get();
        $workshops = Workshop::query()->where('starts_at', '>', now())->get();

        $pairs = [];
        foreach ($peserta as $user) {
            foreach ($workshops as $workshop) {
                $pairs[] = [$user->id, $workshop->id];
            }
        }

        shuffle($pairs);
        $pairs = array_slice($pairs, 0, 22);

        $statuses = ['paid', 'pending', 'paid', 'paid', 'failed', 'pending', 'expired', 'paid'];

        foreach ($pairs as $i => [$userId, $workshopId]) {
            $workshop = $workshops->firstWhere('id', $workshopId);
            $status = $statuses[$i % count($statuses)];

            $registration = Registration::create([
                'user_id' => $userId,
                'workshop_id' => $workshopId,
                'amount' => $workshop->price,
                'payment_status' => $status,
            ]);

            if ($status === 'paid') {
                $registration->forceFill([
                    'order_id' => 'WTX-'.$registration->id.'-'.now()->timestamp,
                    'paid_at' => now()->subHours(random_int(1, 48)),
                    'ticket_code' => 'WTX-'.strtoupper(Str::random(8)),
                ])->save();
            }
        }
    }
}
