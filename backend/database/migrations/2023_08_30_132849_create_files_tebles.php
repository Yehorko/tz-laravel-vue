<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename', 255);
            $table->smallInteger('status')->default(1);
            $table->timestamps();
            $table->string('file_path', 255);
            
            $table->index('status');
        });

        Schema::create('file_rows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->integer('row_number');
            $table->smallInteger('is_valid')->default(1);
            $table->timestamps();
            
            $table->index('file_id');
            $table->index('row_number');
            $table->index('is_valid');
            
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::create('file_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('row_id');
            $table->integer('column_number');
            $table->text('field_value')->nullable();
            $table->smallInteger('is_valid')->default(1);
            $table->timestamps();
            
            $table->index('file_id');
            $table->index('row_id');
            $table->index('column_number');
            $table->index('is_valid');
            
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('row_id')->references('id')->on('file_rows')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_fields');
        Schema::dropIfExists('file_rows');
        Schema::dropIfExists('files');
    }
};

