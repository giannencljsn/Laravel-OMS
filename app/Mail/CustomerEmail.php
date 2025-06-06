<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Batchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerEmail extends Mailable
{
    use SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Your Order Notification')  // Customize subject
                    ->view('emails.customer_order')  // Reference the email view (create this file)
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
