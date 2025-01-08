<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_structures', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->unsignedBigInteger('faculty_id');
            $table->string('pdf_path');
            $table->string('academic_year');
            $table->string('version')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('faculty_id')
                ->references('id')
                ->on('faculties')
                ->onDelete('cascade');

            // Add index for faster queries
            $table->index(['program_name', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_structures');
    }
};
