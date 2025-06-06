<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Update the fields to have a higher character limit
            $table->text('ordered_items')->nullable()->change();
            $table->text('order_sku')->nullable()->change();
            $table->text('customer_name')->nullable()->change();
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
            // Revert the fields to their original data types
            $table->string('ordered_items', 255)->nullable()->change();
            $table->string('order_sku', 255)->nullable()->change();
            $table->string('customer_name', 255)->nullable()->change();
        });
    }
}
