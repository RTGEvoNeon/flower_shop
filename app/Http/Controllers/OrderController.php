<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Order;
use App\Services\YooKassaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct(private readonly YooKassaService $yooKassa) {}

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'total_amount' => 'required|numeric|min:0',
            'product_url' => 'nullable|string|max:2000',
        ]);

        $rawProductUrl = $validated['product_url'] ?? null;
        unset($validated['product_url']);

        $productUrl = is_string($rawProductUrl) && $rawProductUrl !== ''
            ? $rawProductUrl
            : url('/');

        $user = Auth::user();
        if ($user) {
            $validated['user_id'] = $user->id;
        }

        $order = new Order($validated);
        $order->save();

        $adminEmails = (array) config('mail.admin_emails', []);
        if ($adminEmails !== []) {
            try {
                Mail::to($adminEmails)->send(new NewOrderMail($order, $productUrl));
            } catch (\Throwable $e) {
                Log::error('Не удалось отправить письмо о новом заказе', [
                    'order_id' => $order->id,
                    'recipients' => $adminEmails,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if ($this->yooKassa->isPaymentEnabled()) {
            try {
                $confirmationUrl = $this->yooKassa->createPayment($order);

                return response()->json([
                    'success' => true,
                    'payment_url' => $confirmationUrl,
                ]);
            } catch (\Throwable $e) {
                Log::error('Не удалось создать платёж ЮKassa', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.',
        ]);
    }
}
