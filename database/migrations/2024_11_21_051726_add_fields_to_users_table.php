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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            // Changing store_assigned to be an unsignedBigInteger and setting foreign key relationship
            $table->unsignedBigInteger('store_assigned')->nullable();
            $table->foreign('store_assigned')->references('id')->on('phoneville_branches')->onDelete('set null');
            $table->enum('role', ['Superadmin', 'Admin', 'Store_Staff']);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 
                'photo', 
                'phone', 
                'address', 
                'store_assigned', 
                'role', 
                'status'
            ]);
        });
    }
};
