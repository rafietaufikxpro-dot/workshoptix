<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Data dummy untuk Langkah 02 (tampilan saja, belum ke database).
 *
 * // DUMMY — hapus di Langkah 03: ganti pemanggilan DummyData dengan query Eloquent.
 */
class DummyData
{
    public static function workshops(): array
    {
        return [
            (object) [
                'id' => 1,
                'title' => 'Dasar Laravel untuk Pemula',
                'description' => 'Kenalan dengan Laravel: instalasi, routing, controller, dan Blade. Cocok untuk yang baru mulai membuat aplikasi web.',
                'speaker' => 'Bu Rina',
                'venue' => 'Lab RPL',
                'starts_at' => Carbon::parse('2026-12-01 09:00'),
                'ends_at' => Carbon::parse('2026-12-01 12:00'),
                'price' => 50000,
                'quota' => 30,
                'seats_left' => 12,
            ],
            (object) [
                'id' => 2,
                'title' => 'Git untuk Tim',
                'description' => 'Branch, merge, pull request, dan menyelesaikan konflik. Latihan kolaborasi seperti di dunia kerja.',
                'speaker' => 'Pak Dimas',
                'venue' => 'Aula',
                'starts_at' => Carbon::parse('2026-12-03 13:00'),
                'ends_at' => Carbon::parse('2026-12-03 15:30'),
                'price' => 25000,
                'quota' => 40,
                'seats_left' => 25,
            ],
            (object) [
                'id' => 3,
                'title' => 'API dengan Laravel',
                'description' => 'Membuat REST API, validasi request, resource, dan autentikasi token.',
                'speaker' => 'Bu Sari',
                'venue' => 'Lab RPL 2',
                'starts_at' => Carbon::parse('2026-12-05 09:00'),
                'ends_at' => Carbon::parse('2026-12-05 12:00'),
                'price' => 75000,
                'quota' => 25,
                'seats_left' => 0,
            ],
            (object) [
                'id' => 4,
                'title' => 'Tailwind CSS Praktis',
                'description' => 'Membangun tampilan rapi dan responsif tanpa menulis CSS banyak.',
                'speaker' => 'Pak Dimas',
                'venue' => 'Lab Multimedia',
                'starts_at' => Carbon::parse('2026-12-08 10:00'),
                'ends_at' => Carbon::parse('2026-12-08 12:00'),
                'price' => 30000,
                'quota' => 35,
                'seats_left' => 9,
            ],
            (object) [
                'id' => 5,
                'title' => 'Pengenalan Keamanan Web',
                'description' => 'CSRF, SQL injection, XSS, dan cara Laravel melindungi aplikasimu.',
                'speaker' => 'Bu Rina',
                'venue' => 'Aula',
                'starts_at' => Carbon::parse('2026-12-10 13:00'),
                'ends_at' => Carbon::parse('2026-12-10 15:00'),
                'price' => 20000,
                'quota' => 50,
                'seats_left' => 31,
            ],
        ];
    }

    public static function workshop(int|string $id): object
    {
        return collect(self::workshops())->firstWhere('id', (int) $id);
    }

    /**
     * @return array<int, object>
     */
    public static function registrations(): array
    {
        $workshops = self::workshops();

        $rows = [
            ['id' => 1, 'user_id' => 1, 'workshop_id' => 1, 'amount' => 50000, 'order_id' => 'WTX-1-1730000000', 'payment_status' => 'paid', 'ticket_code' => 'WTX-8K2M4N'],
            ['id' => 2, 'user_id' => 1, 'workshop_id' => 2, 'amount' => 25000, 'order_id' => 'WTX-2-1730000001', 'payment_status' => 'pending'],
            ['id' => 3, 'user_id' => 1, 'workshop_id' => 4, 'amount' => 30000, 'order_id' => 'WTX-3-1730000002', 'payment_status' => 'failed'],
            ['id' => 4, 'user_id' => 1, 'workshop_id' => 5, 'amount' => 20000, 'order_id' => null, 'payment_status' => 'expired'],
        ];

        return array_map(function (array $row) use ($workshops) {
            $workshop = collect($workshops)->firstWhere('id', $row['workshop_id']);

            return (object) array_merge($row, [
                'snap_token' => 'dummy-snap-token-'.$row['id'],
                'paid_at' => $row['payment_status'] === 'paid' ? Carbon::parse('2026-11-15 10:00') : null,
                'created_at' => Carbon::parse('2026-11-14 09:00'),
                'user' => (object) ['id' => $row['user_id'], 'name' => 'Peserta Contoh', 'email' => 'peserta@example.com'],
                'workshop' => $workshop,
            ]);
        }, $rows);
    }

    public static function registration(int|string $id): object
    {
        return collect(self::registrations())->firstWhere('id', (int) $id);
    }

    /**
     * Daftar pendaftar untuk dashboard panitia (T-11 butuh ≥ 20 saat DB sudah tersambung).
     *
     * @return array<int, object>
     */
    public static function pendaftar(): array
    {
        $mine = self::registrations();
        $extra = [];

        foreach (range(6, 15) as $id) {
            $workshop = self::workshop((($id % 5) + 1));
            $extra[] = (object) [
                'id' => $id,
                'user_id' => $id,
                'workshop_id' => $workshop->id,
                'amount' => $workshop->price,
                'order_id' => 'WTX-'.$id.'-17300000'.$id,
                'snap_token' => 'dummy-snap-token-'.$id,
                'payment_status' => ['paid', 'pending', 'failed', 'expired'][$id % 4],
                'paid_at' => null,
                'ticket_code' => 'WTX-'.strtoupper(substr(md5((string) $id), 0, 6)),
                'created_at' => Carbon::parse('2026-11-1'.($id % 9).' 08:00'),
                'user' => (object) ['id' => $id, 'name' => 'Peserta '.$id, 'email' => 'peserta'.$id.'@example.com'],
                'workshop' => $workshop,
            ];
        }

        return array_merge($mine, $extra);
    }
}
