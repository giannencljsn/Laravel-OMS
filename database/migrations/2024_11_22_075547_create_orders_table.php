<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->string('invoice_id')->unique();
             // Restrict length of pickup_code to 12 characters
            $table->string('pickup_code', 12)->nullable()->unique();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Pending', 'Paid', 'Shipped', 'Delivered'])->default('Pending');
            $table->string('imei')->nullable();
            $table->integer('stock_available')->default(0);
            $table->timestamp('pickup_date')->nullable();
            $table->timestamp('availability_date')->nullable();
            $table->string('customer_email');
            $table->string('customer_number');
            $table->time('pickup_time')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
