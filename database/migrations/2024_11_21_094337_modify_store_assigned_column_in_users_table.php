<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStoreAssignedColumnInUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change the column type to unsignedBigInteger
            $table->unsignedBigInteger('store_assigned')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert the column type back to varchar (if needed for rollback)
            $table->string('store_assigned', 300)->nullable()->change();
        });
    }
}
