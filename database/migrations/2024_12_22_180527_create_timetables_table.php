<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Link to the course
            $table->string('course_code'); // This should be included in the migration
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade'); // Link to the student, nullable
            $table->string('day_of_week'); // e.g., 'Monday', 'Tuesday'
            $table->time('start_time'); // Start time of the class
            $table->time('end_time'); // End time of the class
            $table->string('place'); // Location of the class
             $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
