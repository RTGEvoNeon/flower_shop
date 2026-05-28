<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Mail\NewOrderMail;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_submit_creates_order_and_sends_email_to_admin(): void
    {
        Mail::fake();
        config(['mail.admin_email' => 'admin@example.com']);

        $response = $this->postJson('/order/submit', [
            'customer_name' => 'Иван Иванов',
            'customer_phone' => '+7 (999) 123-45-67',
            'delivery_address' => 'г. Москва, ул. Тестовая, д. 1',
            'notes' => 'Позвонить после 18:00',
            'total_amount' => 1500,
            'product_url' => 'https://itulip.ru/product/test',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Иван Иванов',
            'customer_phone' => '+7 (999) 123-45-67',
        ]);

        $order = Order::firstOrFail();

        Mail::assertSent(NewOrderMail::class, function (NewOrderMail $mail) use ($order) {
            return $mail->order->is($order)
                && $mail->productUrl === 'https://itulip.ru/product/test'
                && $mail->hasTo('admin@example.com');
        });
    }

    public function test_submit_uses_site_root_when_product_url_is_empty(): void
    {
        Mail::fake();
        config(['mail.admin_email' => 'admin@example.com']);

        $this->postJson('/order/submit', [
            'customer_name' => 'Иван',
            'customer_phone' => '+7 999 000 00 00',
            'total_amount' => 100,
        ])->assertOk();

        Mail::assertSent(NewOrderMail::class, function (NewOrderMail $mail) {
            return $mail->productUrl === url('/');
        });
    }

    public function test_submit_does_not_send_email_when_admin_email_is_empty(): void
    {
        Mail::fake();
        config(['mail.admin_email' => '']);

        $response = $this->postJson('/order/submit', [
            'customer_name' => 'Иван',
            'customer_phone' => '+7 999 000 00 00',
            'total_amount' => 100,
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('orders', 1);

        Mail::assertNothingSent();
    }

    public function test_submit_returns_success_even_if_mail_sending_fails(): void
    {
        config(['mail.admin_email' => 'admin@example.com']);

        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('SMTP недоступен'));

        $response = $this->postJson('/order/submit', [
            'customer_name' => 'Иван',
            'customer_phone' => '+7 999 000 00 00',
            'total_amount' => 100,
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseCount('orders', 1);
    }

    public function test_submit_validates_required_fields(): void
    {
        $response = $this->postJson('/order/submit', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['customer_name', 'customer_phone', 'total_amount']);
    }

    public function test_new_order_mail_renders_with_order_data(): void
    {
        $order = new Order([
            'customer_name' => 'Пётр Петров',
            'customer_phone' => '+7 (911) 222-33-44',
            'delivery_address' => 'СПб, Невский 1',
            'notes' => 'Хрупкое',
            'total_amount' => '2500.00',
        ]);
        $order->id = 42;
        $order->created_at = now();

        $mailable = new NewOrderMail($order, 'https://itulip.ru/product/x');

        $mailable->assertHasSubject('Новая заявка с сайта №42');
        $mailable->assertSeeInHtml('Пётр Петров');
        $mailable->assertSeeInHtml('+7 (911) 222-33-44');
        $mailable->assertSeeInHtml('СПб, Невский 1');
        $mailable->assertSeeInHtml('Хрупкое');
        $mailable->assertSeeInHtml('2500.00');
        $mailable->assertSeeInHtml('https://itulip.ru/product/x');
    }
}
