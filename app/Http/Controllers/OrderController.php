<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected TelegramService $telegramService;
    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function submit(Request $request)
    {   
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'delivery_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $order = new Order($validated);
        $order->save();

        $productUrl = $request->input('product_url', url('/'));

        try {
            $this->telegramService->sendOrderMessage($order, $productUrl);
            return response()->json([
                'success' => true,
                'message' => 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте еще раз позже.'
            ], 500);
        }
    }
}