<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['paid', 'unpaid', 'pending'])->nullable();
            $table->string('ordered_items')->nullable();
            $table->integer('order_quantity')->nullable();
            $table->string('order_sku')->nullable();
            $table->string('customer_name')->nullable();
            $table->enum('pickup_type', ['in_store', 'curbside', 'delivery'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'ordered_items',
                'order_quantity',
                'order_sku',
                'customer_name',
                'pickup_type',
            ]);
        });
    }
}