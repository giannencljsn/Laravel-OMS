<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Mail\CustomerEmail;

use App\Observers\OrderObserver;

#[ObservedBy([OrderObserver::class])]

class Order extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'orders';

    // The primary key associated with the table.
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key in your orders table

    // Indicates if the model should be timestamped.
    public $timestamps = true;

    // The attributes that are mass assignable.
    protected $fillable = [
        'order_id',
        'invoice_id',
        'branch_id',
        'status',
        'imei',
        'stock_available',
        'availability_date',
        'pickup_date',
        'pickup_code',
        'customer_email',
        'customer_number',
        'pickup_time',
        'payment_status',
        'ordered_items',
        'order_quantity',
        'order_sku',
        'customer_name',
        'pickup_type'
    ];

    protected static function booted()
    {
        static::updated(function ($order) {
            // Check if status changed to 'readyforpickup'
            if ($order->status === 'readyforpickup' && $order->isDirty('status')) {
                // Send email
                self::sendReadyForPickupEmail($order);
            }
        });
    }

    public static function sendReadyForPickupEmail(Order $order)
    {
        if ($order->customer_email) {
            Mail::to($order->customer_email)->send(new CustomerEmail($order));
            \Log::info("Email sent to: {$order->customer_email} for Order ID: {$order->order_id}");
        } else {
            \Log::warning("No customer email provided for Order ID: {$order->order_id}");
        }
    }

    // The attributes that should be hidden for arrays.
    protected $hidden = [];

    // The attributes that should be cast to native types.
    protected $casts = [
        'pickup_date' => 'date',
        'availability_date' => 'date',
        'stock_available' => 'integer',
    ];

    // Relationship method for Branch (if exists)
    public function branch()
    {
        // return $this->belongsTo(Branch::class);
        return $this->belongsTo(PhonevilleBranch::class, 'branch_id');
    }

    public function storeBranch()
    {
        return $this->belongsTo(PhonevilleBranch::class, 'branch_id');
    }


}
