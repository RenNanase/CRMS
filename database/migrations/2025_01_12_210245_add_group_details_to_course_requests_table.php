<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('course_requests', function (Blueprint $table) {
            $table->string('group_name')->nullable()->after('group_id');
            $table->string('day_of_week')->nullable()->after('group_name');
            $table->time('time')->nullable()->after('day_of_week');
            $table->string('place')->nullable()->after('time');
        });
    }

    public function down()
    {
        Schema::table('course_requests', function (Blueprint $table) {
            $table->dropColumn(['group_name', 'day_of_week', 'time', 'place']);
        });
    }
};
