<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\NewOrderMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestOrderEmail extends Command
{
    protected $signature = 'order:test-email {--to= : Получатель письма (по умолчанию config(mail.admin_email))}';

    protected $description = 'Отправить тестовое письмо о новом заказе для проверки SMTP';

    public function handle(): int
    {
        $to = $this->option('to');
        if (! is_string($to) || $to === '') {
            $to = config('mail.admin_email');
        }

        if (! is_string($to) || $to === '') {
            $this->error('Не указан получатель: задайте ADMIN_EMAIL в .env или передайте --to=...');

            return self::FAILURE;
        }

        $order = new Order([
            'customer_name' => 'Тестовый Клиент',
            'customer_phone' => '+7 (999) 123-45-67',
            'delivery_address' => 'г. Москва, ул. Тестовая, д. 1',
            'notes' => 'Это тестовое письмо для проверки SMTP. Никакого реального заказа не было.',
            'total_amount' => '1234.56',
            'product_url' => url('/'),
        ]);
        $order->id = 0;
        $order->created_at = now();

        $this->info("Отправляю тестовое письмо на: {$to}");

        Mail::to($to)->send(new NewOrderMail($order));

        $this->info('Готово. Проверьте почту.');

        return self::SUCCESS;
    }
}
