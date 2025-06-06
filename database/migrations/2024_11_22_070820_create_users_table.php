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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key for the users table
            $table->string('name'); // User's name
            $table->string('email')->unique(); // Email address
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->string('password'); // User's password
            $table->rememberToken(); // For "remember me" functionality
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Drop the table if the migration is rolled back
    }
};
