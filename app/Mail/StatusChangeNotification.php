<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class StatusChangeNotification extends Mailable
{
    public $log;
    public $order;

    public function __construct($log)
    {
        $this->log = $log;

        // Fetch the corresponding order using IMEI or order_id
        $this->order = DB::table('orders')->where('imei', $log->imei)->first();
    }

    public function build()
    {
        return $this->subject('Order Status Update')
            ->view('emails.customer_order')
            ->with([
                'log' => $this->log,
                'order' => $this->order, // Pass the order to the template
            ]);
    }
}
