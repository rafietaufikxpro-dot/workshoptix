<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Throwable;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = (string) config('services.midtrans.server_key');
        Config::$clientKey = (string) config('services.midtrans.client_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
    }

    /**
     * Buat (atau pakai ulang) Snap token untuk sebuah pendaftaran.
     * gross_amount selalu dari registrations.amount di server (FR-18).
     */
    public function createSnapToken(Registration $registration): string
    {
        $orderId = $this->resolveOrderId($registration);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $registration->amount,
            ],
            'customer_details' => [
                'first_name' => $registration->user->name,
                'email' => $registration->user->email,
            ],
            'item_details' => [
                [
                    'id' => (string) $registration->workshop_id,
                    'price' => (int) $registration->amount,
                    'quantity' => 1,
                    'name' => Str::limit($registration->workshop->title, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('registrations.show', $registration),
            ],
        ];

        $token = Snap::getSnapToken($params);

        $registration->forceFill([
            'order_id' => $orderId,
            'snap_token' => $token,
        ])->save();

        return $token;
    }

    /**
     * FR-19: pending + snap_token ada → pakai ulang order_id;
     * failed/expired/belum ada → order_id baru.
     */
    protected function resolveOrderId(Registration $registration): string
    {
        if ($registration->payment_status === 'pending'
            && $registration->order_id
            && $registration->snap_token) {
            return $registration->order_id;
        }

        return 'WTX-'.$registration->id.'-'.now()->timestamp;
    }

    /**
     * Tanyakan status ke Midtrans lalu petakan ke status aplikasi (FR-22, 7.3).
     * Error/404 → tetap 'pending', bukan error 500.
     */
    public function checkStatus(Registration $registration): string
    {
        if (! $registration->order_id) {
            return 'pending';
        }

        try {
            $status = Transaction::status($registration->order_id);
        } catch (Throwable) {
            return 'pending';
        }

        return $this->mapStatus($status['transaction_status'] ?? null, $status['fraud_status'] ?? null);
    }

    /**
     * Pemetaan transaction_status Midtrans → status aplikasi.
     */
    public function mapStatus(?string $transactionStatus, ?string $fraudStatus): string
    {
        return match ($transactionStatus) {
            'settlement' => 'paid',
            'capture' => $fraudStatus === 'accept' ? 'paid' : 'pending',
            'pending' => 'pending',
            'deny', 'cancel', 'failure' => 'failed',
            'expire' => 'expired',
            default => 'pending',
        };
    }

    /**
     * Terapkan status dari Midtrans. Saat paid, isi paid_at dan ticket_code
     * hanya sekali (FR-26).
     */
    public function applyStatus(Registration $registration, string $status): void
    {
        $registration->payment_status = $status;

        if ($status === 'paid') {
            $registration->paid_at ??= now();

            if (! $registration->ticket_code) {
                do {
                    $code = 'WTX-'.strtoupper(Str::random(8));
                } while (Registration::where('ticket_code', $code)->exists());

                $registration->ticket_code = $code;
            }
        }

        $registration->save();
    }
}
