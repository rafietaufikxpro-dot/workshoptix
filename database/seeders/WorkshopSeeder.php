<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['title' => 'Dasar Laravel untuk Pemula', 'speaker' => 'Bu Rina', 'venue' => 'Lab RPL', 'price' => 50000, 'quota' => 30, 'days' => 7, 'description' => 'Kenalan dengan Laravel: instalasi, routing, controller, dan Blade.'],
            ['title' => 'Git untuk Tim', 'speaker' => 'Pak Dimas', 'venue' => 'Aula', 'price' => 25000, 'quota' => 40, 'days' => 9, 'description' => 'Branch, merge, pull request, dan menyelesaikan konflik.'],
            ['title' => 'API dengan Laravel', 'speaker' => 'Bu Sari', 'venue' => 'Lab RPL 2', 'price' => 75000, 'quota' => 25, 'days' => 11, 'description' => 'Membuat REST API, validasi request, resource, dan autentikasi token.'],
            ['title' => 'Tailwind CSS Praktis', 'speaker' => 'Pak Dimas', 'venue' => 'Lab Multimedia', 'price' => 30000, 'quota' => 35, 'days' => 14, 'description' => 'Membangun tampilan rapi dan responsif tanpa menulis CSS banyak.'],
            ['title' => 'Pengenalan Keamanan Web', 'speaker' => 'Bu Rina', 'venue' => 'Aula', 'price' => 20000, 'quota' => 50, 'days' => 18, 'description' => 'CSRF, SQL injection, XSS, dan cara Laravel melindungi aplikasimu.'],
        ];

        $panitiaId = User::where('role', 'panitia')->value('id');

        foreach ($data as $item) {
            Workshop::updateOrCreate(
                ['title' => $item['title']],
                [
                    'description' => $item['description'],
                    'speaker' => $item['speaker'],
                    'venue' => $item['venue'],
                    'starts_at' => now()->addDays($item['days'])->setTime(9, 0),
                    'ends_at' => now()->addDays($item['days'])->setTime(12, 0),
                    'price' => $item['price'],
                    'quota' => $item['quota'],
                    'created_by' => $panitiaId,
                ],
            );
        }
    }
}
