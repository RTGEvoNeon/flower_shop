<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Support\Str;
use RuntimeException;
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationFactory;
use YooKassa\Model\Payment\Payment as YooKassaPayment;
use YooKassa\Model\Payment\PaymentStatus;

class YooKassaService
{
    public function isPaymentEnabled(): bool
    {
        return Setting::get('pay_enabled', false);
    }

    /**
     * Создаёт платёж в ЮKassa и возвращает URL, на который нужно перенаправить покупателя.
     */
    public function createPayment(Order $order): string
    {
        if (! $this->isPaymentEnabled()) {
            throw new RuntimeException('Онлайн-оплата отключена в настройках сайта.');
        }

        $idempotenceKey = (string) Str::uuid();

        $response = $this->client()->createPayment([
            'amount' => [
                'value' => number_format((float) $order->total_amount, 2, '.', ''),
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'locale' => 'ru_RU',
                'return_url' => config('payments.yookassa.return_url'),
            ],
            'capture' => true,
            'description' => "Заказ №{$order->id}",
            'metadata' => [
                'order_id' => $order->id,
            ],
        ], $idempotenceKey);

        $order->payment()->create([
            'yookassa_payment_id' => $response->getId(),
            'idempotence_key' => $idempotenceKey,
            'status' => $response->getStatus(),
            'amount' => $order->total_amount,
            'raw_response' => $response instanceof YooKassaPayment ? $response->jsonSerialize() : [],
        ]);

        $confirmationUrl = $response->getConfirmation()?->getConfirmationUrl();

        if (! $confirmationUrl) {
            throw new RuntimeException('ЮKassa не вернула ссылку для оплаты.');
        }

        return $confirmationUrl;
    }

    public function handleWebhookNotification(array $payload): void
    {
        $factory = new NotificationFactory;
        $notification = $factory->factory($payload);

        $isPaymentEvent = in_array($notification->getEvent(), [
            NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE,
            NotificationEventType::PAYMENT_SUCCEEDED,
            NotificationEventType::PAYMENT_CANCELED,
        ], true);

        if (! $isPaymentEvent) {
            return;
        }

        $paymentObject = $notification->getObject();

        $payment = Payment::query()
            ->where('yookassa_payment_id', $paymentObject->getId())
            ->first();

        if (! $payment) {
            return;
        }

        // Не доверяем статусу из тела уведомления — перепроверяем напрямую через API.
        $actual = $this->client()->getPaymentInfo($payment->yookassa_payment_id);

        $payment->update([
            'status' => $actual->getStatus(),
            'raw_response' => $actual instanceof YooKassaPayment ? $actual->jsonSerialize() : [],
        ]);

        if ($notification->getEvent() === NotificationEventType::PAYMENT_SUCCEEDED
            && $actual->getStatus() === PaymentStatus::SUCCEEDED) {
            $payment->order()->update(['status' => 'confirmed']);
        }

        if ($notification->getEvent() === NotificationEventType::PAYMENT_CANCELED
            && $actual->getStatus() === PaymentStatus::CANCELED) {
            $payment->order()->update(['status' => 'cancelled']);
        }
    }

    public function isNotificationIpTrusted(string $ip): bool
    {
        return $this->client()->isNotificationIPTrusted($ip);
    }

    private function client(): Client
    {
        $client = new Client;
        $client->setAuth(
            (int) Setting::get('yookassa_shop_id', 0),
            (string) config('payments.yookassa.secret_key')
        );

        return $client;
    }
}
