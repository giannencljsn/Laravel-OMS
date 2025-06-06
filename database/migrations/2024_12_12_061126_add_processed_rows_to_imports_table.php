<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcessedRowsToImportsTable extends Migration
{
    public function up()
    {
        Schema::table('imports', function (Blueprint $table) {
            $table->integer('processed_rows')->default(0)->after('total_rows');
            $table->integer('successful_rows')->default(0)->after('processed_rows');
        });
    }

    public function down()
    {
        Schema::table('imports', function (Blueprint $table) {
            $table->dropColumn(['processed_rows', 'successful_rows']);
        });
    }
}
