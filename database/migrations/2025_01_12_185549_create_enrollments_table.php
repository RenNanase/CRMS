<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('active');
            $table->timestamps();

            // Prevent duplicate enrollments
            $table->unique(['student_id', 'group_id', 'course_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};
