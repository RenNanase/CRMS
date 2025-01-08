<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->string('course_name')->after('course_code'); // Add course_name column
            $table->foreignId('lecturer_id')->after('course_id')->constrained(); // Add lecturer_id column
        });
    }

    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropColumn('course_name');
            $table->dropForeign(['lecturer_id']);
            $table->dropColumn('lecturer_id');
        });
    }
};
