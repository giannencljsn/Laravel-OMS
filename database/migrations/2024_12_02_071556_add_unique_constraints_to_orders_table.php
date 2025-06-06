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
        Schema::table('orders', function (Blueprint $table) {
            $table->unique('imei');
            $table->unique('order_id');
            $table->unique('invoice_id');
            $table->unique('pickup_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['imei']);
            $table->dropUnique(['order_id']);
            $table->dropUnique(['invoice_id']);
            $table->dropUnique(['pickup_code']);
        });
    }
};
