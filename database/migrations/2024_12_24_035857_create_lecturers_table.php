<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->unsignedBigInteger('lecturer_id');
            $table->string('expertise')->nullable();
            $table->string('name'); // Name of the lecturer
            $table->string('email')->unique(); // Email must be unique
            $table->unsignedBigInteger('faculty_id')->nullable(); // Add faculty_id column
            $table->unsignedBigInteger('course_id')->nullable(); // Add course_id column
            $table->string('phone')->nullable();

            $table->timestamps(); // Created at and updated at timestamps

            // Foreign key constraints
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('set null');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('lecturers');
    }
}
