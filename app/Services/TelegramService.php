<?php
namespace App\Services;

use TelegramBot\Api\BotApi;


class TelegramService
{
    protected BotApi $telegram;
    protected string $chatId;

    public function __construct()
    {
        $this->telegram = new BotApi(config('services.telegram.bot_token'));
        $this->chatId = config('services.telegram.chat_id');
    }

    function simple_message()
    {
        $this->telegram->sendMessage(config('services.telegram.chat_id'), 'Привет, это тестовое сообщение!');
    }

    function sendOrderMessage($order, $productUrl) {
        $message = "🌸 Новый заказ!\n\n";
        $message .= "Букет: " . $productUrl . "\n\n";
        $message .= "👤 Имя: " . $order->customer_name . "\n";
        $message .= "📱 Телефон: " . $order->customer_phone . "\n";
        $message .= "📍 Адрес: " . $order->delivery_address . "\n";
        $message .= "💬 Комментарий: " . $order->notes . "\n";
        $message .= "💰 Сумма заказа: " . number_format($order->total_amount, 0, ',', ' ') . " руб.\n";

        $this->telegram->sendMessage($this->chatId, $message);
    }


    //методы для отправки сообщений, фотографий и т.д.

    //отправка уведомлений о новых заказах

}