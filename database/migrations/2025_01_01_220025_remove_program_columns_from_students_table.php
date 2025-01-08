<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['program_name', 'program_code']);
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('program_name')->nullable();
            $table->string('program_code')->nullable();
        });
    }
};
