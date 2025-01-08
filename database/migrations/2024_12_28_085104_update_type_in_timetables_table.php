<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Timetable;
use App\Models\Course;

return new class extends Migration
{
    public function up()
    {
        // First ensure the type column exists
        if (!Schema::hasColumn('timetables', 'type')) {
            Schema::table('timetables', function (Blueprint $table) {
                $table->string('type')->nullable()->after('place');
            });
        }

        // Update existing records
        $timetables = Timetable::all();
        foreach ($timetables as $timetable) {
            $course = Course::find($timetable->course_id);
            if ($course) {
                $timetable->update(['type' => $course->type]);
            }
        }
    }

    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
