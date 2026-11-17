<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Throwable;

class PaymentController extends Controller
{
    /**
     * Tombol Bayar: buat/pakai ulang Snap token, kirim token ke halaman status (FR-19).
     */
    public function pay(Registration $registration): RedirectResponse
    {
        $this->authorize('view', $registration);

        if ($registration->payment_status === 'paid') {
            return redirect()->route('registrations.show', $registration)
                ->with('status', 'Pembayaran sudah lunas.');
        }

        try {
            $token = app(MidtransService::class)->createSnapToken($registration);
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal membuat transaksi Midtrans: '.$e->getMessage());
        }

        return redirect()->route('registrations.show', $registration)
            ->with('snap_token', $token)
            ->with('status', 'Lanjutkan pembayaran di jendela Snap.');
    }

    /**
     * Tombol Cek Status: tanya Midtrans lalu terapkan status (FR-22).
     */
    public function check(Registration $registration): RedirectResponse
    {
        $this->authorize('view', $registration);

        try {
            $status = app(MidtransService::class)->checkStatus($registration);
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal mengecek status pembayaran: '.$e->getMessage());
        }

        app(MidtransService::class)->applyStatus($registration, $status);

        $message = match ($status) {
            'paid' => 'Pembayaran lunas! Tiket digital sudah tersedia.',
            'failed' => 'Pembayaran gagal. Silakan coba bayar lagi.',
            'expired' => 'Pembayaran kedaluwarsa. Silakan bayar lagi.',
            default => 'Selesaikan pembayaran dulu di jendela Snap.',
        };

        return redirect()->route('registrations.show', $registration)
            ->with($status === 'paid' ? 'success' : ($status === 'pending' ? 'status' : 'error'), $message);
    }
}
