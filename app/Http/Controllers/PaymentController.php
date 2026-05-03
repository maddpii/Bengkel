<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class PaymentController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $transactions = Transaction::query()
            ->whereHas('booking', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with(['booking.vehicle', 'mekanik', 'kasir', 'payment'])
            ->whereHas('payment')
            ->orderByDesc('id')
            ->get();

        return view('payment.index', compact('transactions'));
    }

    public function store(Request $r)
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $validated = $r->validate([
            'transaction_id' => ['required', 'exists:transactions,id'],
            'payer_name' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:cash,transfer,qris'],
            'payer_notes' => ['nullable', 'string'],
        ]);

        $transaction = Transaction::query()
            ->whereHas('booking', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('payment')
            ->findOrFail($validated['transaction_id']);

        Payment::query()->updateOrCreate(
            ['transaction_id' => $transaction->id],
            [
                'payment_date' => $transaction->payment?->payment_date ?? now()->toDateString(),
                'amount_paid' => $transaction->payment?->amount_paid ?? 0,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $transaction->payment?->payment_status ?? 'unpaid',
                'payer_name' => trim($validated['payer_name']),
                'payer_notes' => filled($validated['payer_notes'] ?? null) ? trim($validated['payer_notes']) : null,
                'submitted_at' => now(),
            ]
        );

        return redirect()
            ->route('payments.index')
            ->with('success', 'Form pembayaran berhasil dikirim.');
    }

    public function snap(Transaction $transaction): JsonResponse
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $transaction = $this->ownedTransaction($transaction->id);
        $payment = $transaction->payment;
        abort_unless($payment, 404);

        $this->configureMidtrans();

        $orderId = 'TRX-' . $transaction->id . '-' . Str::upper(Str::ulid());

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) round($transaction->grand_total),
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
            ],
            'item_details' => [
                [
                    'id' => 'service-' . $transaction->id,
                    'price' => (int) round($transaction->grand_total),
                    'quantity' => 1,
                    'name' => 'Tagihan Servis #' . $transaction->id,
                ],
            ],
            'callbacks' => [
                'finish' => route('payments.index'),
            ],
        ];

        try {
            Log::info('Membuat Snap token Midtrans.', [
                'transaction_id' => $transaction->id,
                'order_id' => $orderId,
                'gross_amount' => (int) round($transaction->grand_total),
                'customer_email' => auth()->user()->email,
                'is_production' => (bool) config('services.midtrans.is_production', false),
                'app_url' => config('app.url'),
            ]);

            $snapToken = Snap::getSnapToken($params);

            Log::info('Snap token Midtrans berhasil dibuat.', [
                'transaction_id' => $transaction->id,
                'order_id' => $orderId,
                'snap_token_preview' => substr($snapToken, 0, 12) . '...',
            ]);
        } catch (\Throwable $exception) {
            Log::error('Gagal membuat Snap token Midtrans.', [
                'transaction_id' => $transaction->id,
                'order_id' => $orderId,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Tidak bisa terhubung ke Midtrans saat ini. Coba lagi beberapa saat.',
            ], 422);
        }

        $payment->update([
            'midtrans_order_id' => $orderId,
            'midtrans_transaction_id' => null,
            'midtrans_status' => 'pending',
            'payer_name' => $payment->payer_name ?: auth()->user()->name,
            'snap_token' => $snapToken,
            'midtrans_response' => $params,
        ]);

        return response()->json([
            'snap_token' => $snapToken,
            'is_reused' => false,
        ]);
    }

    public function handleSnapResult(Request $request, Transaction $transaction): JsonResponse
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $transaction = $this->ownedTransaction($transaction->id);
        $payment = $transaction->payment;
        abort_unless($payment, 404);

        $payload = $request->validate([
            'transaction_status' => ['nullable', 'string'],
            'payment_type' => ['nullable', 'string'],
            'transaction_id' => ['nullable', 'string'],
            'order_id' => ['nullable', 'string'],
            'gross_amount' => ['nullable'],
            'fraud_status' => ['nullable', 'string'],
        ]);

        Log::info('Hasil Snap Midtrans diterima dari frontend.', [
            'transaction_id' => $transaction->id,
            'order_id' => $payload['order_id'] ?? null,
            'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
            'transaction_status' => $payload['transaction_status'] ?? null,
            'payment_type' => $payload['payment_type'] ?? null,
        ]);

        $this->applyMidtransResult($payment, $payload);

        return response()->json(['ok' => true]);
    }

    public function refreshStatus(Transaction $transaction): JsonResponse
    {
        abort_unless(auth()->user()?->role === 'customer', 403);

        $transaction = $this->ownedTransaction($transaction->id);
        $payment = $transaction->payment;
        abort_unless($payment && $payment->midtrans_order_id, 404);

        $this->configureMidtrans();
        try {
            $statusReference = $payment->midtrans_transaction_id ?: $payment->midtrans_order_id;
            $result = MidtransTransaction::status($statusReference);
        } catch (\Throwable $exception) {
            if (str_contains(strtolower($exception->getMessage()), "transaction doesn't exist")) {
                $payment->update([
                    'midtrans_status' => 'not_found',
                    'midtrans_transaction_id' => null,
                    'midtrans_order_id' => null,
                    'snap_token' => null,
                ]);

                return response()->json([
                    'message' => 'Transaksi Midtrans sebelumnya tidak ditemukan. Silakan klik Bayar Sekarang lagi untuk membuat transaksi baru.',
                ], 422);
            }

            Log::warning('Gagal mengecek status Midtrans.', [
                'transaction_id' => $transaction->id,
                'transaction_reference' => $payment->midtrans_transaction_id,
                'order_id' => $payment->midtrans_order_id,
                'message' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Status pembayaran belum bisa dicek sekarang. Silakan coba lagi.',
            ], 422);
        }

        $this->applyMidtransResult($payment, (array) $result);

        return response()->json([
            'status' => $payment->fresh()->payment_status,
        ]);
    }

    public function notification(): JsonResponse
    {
        $this->configureMidtrans();

        $notification = new Notification();
        Log::info('Notification Midtrans diterima.', [
            'order_id' => $notification->order_id ?? null,
            'transaction_status' => $notification->transaction_status ?? null,
            'payment_type' => $notification->payment_type ?? null,
            'transaction_id' => $notification->transaction_id ?? null,
        ]);

        $payment = Payment::query()
            ->where('midtrans_order_id', $notification->order_id)
            ->first();

        if (! $payment) {
            return response()->json(['message' => 'payment not found'], 404);
        }

        $this->applyMidtransResult($payment, (array) $notification);

        return response()->json(['ok' => true]);
    }

    protected function ownedTransaction(int $transactionId): Transaction
    {
        return Transaction::query()
            ->whereHas('booking', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('payment')
            ->findOrFail($transactionId);
    }

    protected function configureMidtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = false;
    }

    protected function normalizePaymentMethod(?string $paymentType, array $payload = []): string
    {
        $paymentType = strtolower((string) $paymentType);

        return match ($paymentType) {
            'bank_transfer', 'echannel', 'cstore', 'akulaku', 'credit_card' => 'transfer',
            'qris', 'gopay', 'shopeepay' => 'qris',
            'cash' => 'cash',
            default => strtolower((string) ($payload['store'] ?? '')) === 'indomaret' ? 'transfer' : 'transfer',
        };
    }

    protected function applyMidtransResult(Payment $payment, array $payload): void
    {
        $shouldSendInvoiceEmail = false;

        DB::transaction(function () use ($payment, $payload, &$shouldSendInvoiceEmail) {
            $payment->refresh();
            $transactionStatus = strtolower((string) ($payload['transaction_status'] ?? 'pending'));
            $paymentType = strtolower((string) ($payload['payment_type'] ?? $payment->payment_method ?? 'transfer'));
            $normalizedPaymentMethod = $this->normalizePaymentMethod($paymentType, $payload);
            $grossAmount = (float) ($payload['gross_amount'] ?? $payment->transaction?->grand_total ?? 0);
            $fraudStatus = strtolower((string) ($payload['fraud_status'] ?? 'accept'));
            $wasPaid = $payment->payment_status === 'paid';

            $paymentStatus = match (true) {
                in_array($transactionStatus, ['settlement'], true) => 'paid',
                $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'paid',
                in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true) => 'unpaid',
                default => 'unpaid',
            };

            $payment->update([
                'payment_date' => $paymentStatus === 'paid' ? now()->toDateString() : $payment->payment_date,
                'amount_paid' => $paymentStatus === 'paid' ? $grossAmount : 0,
                'payment_method' => $normalizedPaymentMethod,
                'payment_status' => $paymentStatus,
                'submitted_at' => now(),
                'midtrans_transaction_id' => $payload['transaction_id'] ?? $payment->midtrans_transaction_id,
                'midtrans_status' => $transactionStatus,
                'midtrans_response' => $payload,
            ]);

            $shouldSendInvoiceEmail = ! $wasPaid
                && $paymentStatus === 'paid'
                && is_null($payment->invoice_emailed_at);
        });

        if ($shouldSendInvoiceEmail) {
            $this->sendPaidInvoiceEmail($payment->fresh());
        }
    }

    protected function sendPaidInvoiceEmail(Payment $payment): void
    {
        $payment->loadMissing([
            'transaction.booking.user',
            'transaction.booking.services',
            'transaction.booking.vehicle',
            'transaction.spareparts',
            'transaction.mekanik',
            'transaction.kasir',
        ]);

        $transaction = $payment->transaction;
        $customer = $transaction?->booking?->user;

        if (! $transaction || ! $customer?->email || $payment->invoice_emailed_at) {
            return;
        }

        $serviceItems = collect($transaction->booking?->services ?? [])
            ->map(function ($service) {
                return [
                    'name' => $service->service_name,
                    'qty' => 1,
                    'price' => (float) $service->pivot->price,
                    'subtotal' => (float) $service->pivot->price,
                ];
            });

        if (($transaction->manual_service_price ?? 0) > 0 || filled($transaction->manual_service_name)) {
            $serviceItems->push([
                'name' => $transaction->manual_service_name ?: 'Biaya jasa tambahan',
                'qty' => 1,
                'price' => (float) $transaction->manual_service_price,
                'subtotal' => (float) $transaction->manual_service_price,
            ]);
        }

        $sparepartItems = $transaction->spareparts->map(function ($sparepart) {
            return [
                'name' => $sparepart->name,
                'qty' => (int) $sparepart->pivot->qty,
                'price' => (float) $sparepart->pivot->price,
                'subtotal' => (float) $sparepart->pivot->subtotal,
            ];
        });

        try {
            Mail::send('emails.paid-invoice', [
                'transaction' => $transaction,
                'customer' => $customer,
                'payment' => $payment,
                'serviceItems' => $serviceItems,
                'sparepartItems' => $sparepartItems,
            ], function ($message) use ($transaction, $customer) {
                $message->to($customer->email, $customer->name)
                    ->subject('Invoice Pembayaran Servis #' . $transaction->id . ' - Bengkel Mobil');
            });

            $payment->forceFill([
                'invoice_emailed_at' => now(),
            ])->save();
        } catch (\Throwable $exception) {
            Log::error('Gagal mengirim email invoice pembayaran.', [
                'transaction_id' => $transaction->id,
                'payment_id' => $payment->id,
                'customer_email' => $customer->email,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
