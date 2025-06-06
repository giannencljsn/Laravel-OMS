<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add unique constraints to the necessary columns
            $table->unique('imei');
            $table->unique('order_id');
            $table->unique('invoice_id');
            $table->unique('pickup_code');
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
            // Drop the unique constraints
            $table->dropUnique(['imei']);
            $table->dropUnique(['order_id']);
            $table->dropUnique(['invoice_id']);
            $table->dropUnique(['pickup_code']);
        });
    }
};

