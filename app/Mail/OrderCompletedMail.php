<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Fatura da Encomenda #' . $this->order->id)
                    ->markdown('emails.order_receipt')
                    ->attach(storage_path('app/public/receipts/' . $this->order->pdf_receipt));
    }
}
