<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\WholesaleOrderRequest;
use App\Models\WholesaleProduct;
use App\Services\TelegramNotificationService;
use App\Services\WholesalePriceCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class WholesaleOrderController extends Controller
{
    public function __construct(
        private readonly WholesalePriceCalculator $priceCalculator,
        private readonly TelegramNotificationService $telegramService
    ) {}

    /**
     * Обработка оптового заказа
     */
    public function submit(WholesaleOrderRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            
            // Получаем товар
            $product = WholesaleProduct::where('slug', $validated['product_slug'])
                ->available()
                ->firstOrFail();

            // Рассчитываем стоимость
            $quantity = (int) $validated['quantity'];
            $pricePerUnit = $this->priceCalculator->getPricePerUnit($product, $quantity);
            $total = $this->priceCalculator->calculateTotal($product, $quantity);

            // Подготавливаем данные клиента
            $customerData = [
                'name' => $validated['customer_name'],
                'phone' => $validated['customer_phone'],
                'notes' => $validated['notes'] ?? '',
            ];

            // Отправляем в Telegram
            $sent = $this->telegramService->sendWholesaleOrder(
                $product,
                $quantity,
                $pricePerUnit,
                $total,
                $customerData
            );

            if (!$sent) {
                Log::warning('Telegram notification failed for wholesale order', [
                    'product' => $product->slug,
                    'customer' => $customerData['name'],
                ]);
            }

            // Логируем успешный заказ
            Log::info('Wholesale order submitted', [
                'product' => $product->name,
                'quantity' => $quantity,
                'total' => $total,
                'customer' => $customerData['name'],
                'telegram_sent' => $sent,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Заказ успешно отправлен! Мы свяжемся с вами в ближайшее время.',
                'data' => [
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price_per_unit' => $pricePerUnit,
                    'total' => $total,
                ],
            ]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error processing wholesale order', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при обработке заказа. Пожалуйста, попробуйте позже или свяжитесь с нами по телефону.',
            ], 500);
        }
    }
}
