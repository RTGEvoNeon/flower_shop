<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\WholesaleProduct;
use Illuminate\Support\Facades\Log;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;

class TelegramNotificationService
{
    private BotApi $telegram;

    private string $chatId;

    public function __construct()
    {
        $this->telegram = new BotApi(config('services.telegram.bot_token'));
        $this->chatId = config('services.telegram.chat_id');
    }

    /**
     * Отправить уведомление об оптовом заказе в Telegram
     */
    public function sendWholesaleOrder(
        WholesaleProduct $product,
        int $quantity,
        float $pricePerUnit,
        float $total,
        array $customerData
    ): bool {
        $message = $this->formatWholesaleOrderMessage(
            $product,
            $quantity,
            $pricePerUnit,
            $total,
            $customerData
        );

        return $this->sendMessage($message);
    }

    /**
     * Форматировать сообщение об оптовом заказе
     */
    private function formatWholesaleOrderMessage(
        WholesaleProduct $product,
        int $quantity,
        float $pricePerUnit,
        float $total,
        array $customerData
    ): string {
        $formattedTotal = number_format($total, 2, ',', ' ');
        $formattedPrice = number_format($pricePerUnit, 2, ',', ' ');

        $message = "🌷 <b>НОВЫЙ ОПТОВЫЙ ЗАКАЗ</b>\n\n";
        $message .= "<b>Товар:</b> {$product->name}\n";
        $message .= '<b>Количество:</b> '.number_format($quantity, 0, '', ' ')." шт\n";
        $message .= "<b>Цена за шт:</b> {$formattedPrice}₽\n";
        $message .= "<b>Итого:</b> {$formattedTotal}₽\n\n";

        $message .= "👤 <b>Клиент:</b> {$customerData['name']}\n";
        $message .= "📞 <b>Телефон:</b> {$customerData['phone']}\n";

        if (! empty($customerData['notes'])) {
            $message .= "\n💬 <b>Комментарий:</b> {$customerData['notes']}\n";
        }

        return $message;
    }

    /**
     * Отправить сообщение в Telegram
     */
    private function sendMessage(string $message): bool
    {
        if (empty($this->chatId)) {
            Log::warning('Telegram chat_id not configured. Message not sent.', [
                'message' => $message,
            ]);

            return false;
        }

        try {
            $this->telegram->sendMessage($this->chatId, $message, 'HTML');

            Log::info('Telegram notification sent successfully', [
                'chat_id' => $this->chatId,
            ]);

            return true;

        } catch (Exception $e) {
            Log::error('Failed to send Telegram notification', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('Exception while sending Telegram notification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Проверить конфигурацию Telegram
     */
    public function isConfigured(): bool
    {
        return ! empty($this->chatId) && ! empty(config('services.telegram.bot_token'));
    }
}
