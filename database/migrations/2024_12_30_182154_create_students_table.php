<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('matric_number');
            $table->string('program_name');
            $table->string('program_code');
            $table->string('ic_number');
            $table->string('current_semester');
            $table->string('phone');
            $table->string('academic_year');
            $table->string('batch');
            $table->string('intake');
            $table->text('address');
            $table->string('scholarship_status')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
