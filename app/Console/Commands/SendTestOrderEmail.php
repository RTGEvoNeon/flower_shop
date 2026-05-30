<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\NewOrderMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestOrderEmail extends Command
{
    protected $signature = 'order:test-email {--to= : Получатели через запятую (по умолчанию config(mail.admin_emails))}';

    protected $description = 'Отправить тестовое письмо о новом заказе для проверки SMTP';

    public function handle(): int
    {
        $toOption = $this->option('to');
        if (is_string($toOption) && $toOption !== '') {
            $recipients = array_values(array_filter(array_map('trim', explode(',', $toOption))));
        } else {
            $recipients = (array) config('mail.admin_emails', []);
        }

        if ($recipients === []) {
            $this->error('Не указан получатель: задайте ADMIN_EMAIL в .env или передайте --to=a@b.ru,c@d.ru');

            return self::FAILURE;
        }

        $order = new Order([
            'customer_name' => 'Тестовый Клиент',
            'customer_phone' => '+7 (999) 123-45-67',
            'delivery_address' => 'г. Москва, ул. Тестовая, д. 1',
            'notes' => 'Это тестовое письмо для проверки SMTP. Никакого реального заказа не было.',
            'total_amount' => '1234.56',
        ]);
        $order->id = 0;
        $order->created_at = now();

        $this->info('Отправляю тестовое письмо на: '.implode(', ', $recipients));

        Mail::to($recipients)->send(new NewOrderMail($order, url('/')));

        $this->info('Готово. Проверьте почту.');

        return self::SUCCESS;
    }
}
