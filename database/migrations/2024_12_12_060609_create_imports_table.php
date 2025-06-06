<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('file_name'); // Name of the file
            $table->string('file_path'); // Path to the file
            $table->string('importer'); // Importer class name
            $table->integer('total_rows'); // Total rows in the file
            $table->timestamps(); // Includes `created_at` and `updated_at`

            // Optional: Add a foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
