<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomBouquetController extends Controller
{
    /**
     * Показать форму создания букета
     */
    public function show()
    {
        return view('custom-bouquet');
    }

    /**
     * Обработка отправки формы и отправка в Telegram
     */
    public function submit(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'color_scheme' => 'nullable|string',
            'mood' => 'nullable|string',
            'favorite_flowers' => 'nullable|string',
            'special_wishes' => 'nullable|string',
            'budget' => 'nullable|string',
            'custom_budget' => 'nullable|string',
            'contact_method' => 'nullable|array',
        ]);

        // Формируем сообщение для Telegram
        $message = $this->formatTelegramMessage($validated);

        // Отправляем в Telegram
        $sent = $this->sendToTelegram($message);

        if ($sent) {
            return redirect()->back()->with('success', '✅ Спасибо! Ваша заявка отправлена. Мы свяжемся с вами в ближайшее время!');
        } else {
            return redirect()->back()->with('error', '❌ Произошла ошибка при отправке. Пожалуйста, позвоните нам: 8 (953) 292-92-46');
        }
    }

    /**
     * Форматирование сообщения для Telegram
     */
    private function formatTelegramMessage(array $data): string
    {
        $message = "🌸 <b>НОВАЯ ЗАЯВКА НА КАСТОМНЫЙ БУКЕТ</b>\n\n";

        $message .= "👤 <b>Контакты:</b>\n";
        $message .= "Имя: {$data['customer_name']}\n";
        $message .= "Телефон: {$data['phone']}\n";

        if (!empty($data['contact_method'])) {
            $methods = implode(', ', $data['contact_method']);
            $message .= "Связь: {$methods}\n";
        }

        $message .= "\n💰 <b>Бюджет:</b>\n";
        if (!empty($data['custom_budget'])) {
            $message .= "{$data['custom_budget']}\n";
        } elseif (!empty($data['budget'])) {
            $message .= "{$data['budget']} ₽\n";
        } else {
            $message .= "Не указан\n";
        }

        if (!empty($data['color_scheme'])) {
            $message .= "\n🎨 <b>Цветовая гамма:</b>\n{$data['color_scheme']}\n";
        }

        if (!empty($data['mood'])) {
            $message .= "\n💭 <b>Настроение:</b>\n{$data['mood']}\n";
        }

        if (!empty($data['favorite_flowers'])) {
            $message .= "\n🌹 <b>Любимые цветы:</b>\n{$data['favorite_flowers']}\n";
        }

        if (!empty($data['special_wishes'])) {
            $message .= "\n✨ <b>Особые пожелания:</b>\n{$data['special_wishes']}\n";
        }

        $message .= "\n📅 <b>Дата заявки:</b> " . now()->format('d.m.Y H:i');

        return $message;
    }

    /**
     * Отправка сообщения в Telegram
     */
    private function sendToTelegram(string $message): bool
    {
        $botToken = env('TELEGRAM_BOT_TOKEN', '7510083058:AAGlbf4ELDiS0n4sCDi0CxHtdebzIBj0N98');
        $chatId = env('TELEGRAM_CHAT_ID'); // УКАЖИТЕ ВАШ CHAT_ID В .env

        if (empty($chatId)) {
            Log::error('TELEGRAM_CHAT_ID не указан в .env файле');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                Log::info('Заявка на кастомный букет отправлена в Telegram', ['response' => $response->json()]);
                return true;
            } else {
                Log::error('Ошибка отправки в Telegram', ['response' => $response->body()]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Исключение при отправке в Telegram: ' . $e->getMessage());
            return false;
        }
    }
}
