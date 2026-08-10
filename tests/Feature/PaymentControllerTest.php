<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Setting;
use App\Services\YooKassaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_submit_does_not_create_payment_when_pay_enabled_is_false(): void
    {
        Mail::fake();
        Setting::set('pay_enabled', false);

        $response = $this->postJson('/order/submit', [
            'customer_name' => 'Иван',
            'customer_phone' => '+7 999 000 00 00',
            'total_amount' => 100,
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $response->assertJsonMissing(['payment_url']);

        $this->assertDatabaseCount('payments', 0);
    }

    public function test_order_submit_creates_payment_and_returns_confirmation_url_when_pay_enabled(): void
    {
        Mail::fake();
        Setting::set('pay_enabled', true);
        Setting::set('yookassa_shop_id', 'test-shop-id');

        $this->mock(YooKassaService::class, function (MockInterface $mock) {
            $mock->shouldReceive('isPaymentEnabled')->andReturn(true);
            $mock->shouldReceive('createPayment')
                ->once()
                ->andReturn('https://yookassa.ru/checkout/payments/v2/contract?orderId=test');
        });

        $response = $this->postJson('/order/submit', [
            'customer_name' => 'Иван',
            'customer_phone' => '+7 999 000 00 00',
            'total_amount' => 100,
        ]);

        $response->assertOk()->assertJson([
            'success' => true,
            'payment_url' => 'https://yookassa.ru/checkout/payments/v2/contract?orderId=test',
        ]);
    }

    public function test_order_submit_falls_back_to_no_payment_response_when_payment_creation_fails(): void
    {
        Mail::fake();
        Setting::set('pay_enabled', true);

        $this->mock(YooKassaService::class, function (MockInterface $mock) {
            $mock->shouldReceive('isPaymentEnabled')->andReturn(true);
            $mock->shouldReceive('createPayment')
                ->once()
                ->andThrow(new \RuntimeException('ЮKassa недоступна'));
        });

        $response = $this->postJson('/order/submit', [
            'customer_name' => 'Иван',
            'customer_phone' => '+7 999 000 00 00',
            'total_amount' => 100,
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $response->assertJsonMissing(['payment_url']);
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_payment_return_page_is_accessible(): void
    {
        $this->get('/payment/return')->assertOk();
    }
}
