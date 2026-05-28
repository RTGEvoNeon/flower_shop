<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Order $order,
        public readonly ?string $productUrl = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новая заявка с сайта №'.$this->order->id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new_order',
            with: [
                'order' => $this->order,
                'productUrl' => $this->productUrl,
            ],
        );
    }
}
