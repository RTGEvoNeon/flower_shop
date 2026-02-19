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
        $message = "🌸 <b>Новый заказ!</b>\n\n";
        $message .= "<b>Букет:</b> " . $productUrl . "\n\n";
        $message .= "👤 <b>Имя:</b> " . $order->customer_name . "\n";
        $message .= "📱 <b>Телефон:</b> " . $order->customer_phone . "\n";
        $message .= "📍 <b>Адрес:</b> " . $order->delivery_address . "\n";
        $message .= "💬 <b>Комментарий:</b> " . $order->notes . "\n";
        $message .= "💰 <b>Сумма заказа:</b> " . number_format($order->total_amount, 0, ',', ' ') . " руб.\n";

        $this->telegram->sendMessage($this->chatId, $message, 'HTML');
    }


    //методы для отправки сообщений, фотографий и т.д.

    //отправка уведомлений о новых заказах

}