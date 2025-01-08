<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('semester_name'); // Semester name
            $table->string('event_type'); // Type of event
            $table->string('event_title'); // Title of the event
            $table->date('start_date'); // Start date of the event
            $table->date('end_date'); // End date of the event
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
