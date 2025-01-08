<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('group_name'); // Group name (A, B, C, etc.)
            $table->integer('capacity')->default(30); // Maximum capacity
            $table->integer('current_enrollment')->default(0); // Current number of enrolled students
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Foreign key to courses table
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('groups');
    }
}