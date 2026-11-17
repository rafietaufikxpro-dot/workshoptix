<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'panitia@workshoptix.test'],
            [
                'name' => 'Panitia WorkshopTIX',
                'password' => Hash::make('password'),
                'role' => 'panitia',
                'email_verified_at' => now(),
            ],
        );

        foreach (range(1, 8) as $i) {
            User::updateOrCreate(
                ['email' => "peserta{$i}@workshoptix.test"],
                [
                    'name' => "Peserta {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'peserta',
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
