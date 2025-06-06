<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStoreAssignedColumnToVarcharInUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change the column type back to varchar(300)
            $table->string('store_assigned', 300)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert back to unsignedBigInteger if you need to roll back
            $table->unsignedBigInteger('store_assigned')->nullable()->change();
        });
    }
}
