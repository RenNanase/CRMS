<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToGroupsTable extends Migration
{
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            // Add these columns if they don't exist
            if (!Schema::hasColumn('groups', 'day_of_week')) {
                $table->string('day_of_week')->nullable();
            }
            if (!Schema::hasColumn('groups', 'time')) {
                $table->time('time')->nullable();
            }
            if (!Schema::hasColumn('groups', 'max_students')) {
                $table->integer('max_students')->default(30);
            }
            if (!Schema::hasColumn('groups', 'course_id')) {
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            // Drop the columns in reverse order
            $table->dropForeign(['course_id']);
            $table->dropColumn([
                'day_of_week',
                'time',
                'max_students',
                'course_id'
            ]);
        });
    }
}
