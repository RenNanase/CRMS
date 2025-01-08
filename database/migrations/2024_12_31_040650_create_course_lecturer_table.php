<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_lecturer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('lecturer_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Add unique constraint to prevent duplicate assignments
            $table->unique(['course_id', 'lecturer_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_lecturer');
    }
};
