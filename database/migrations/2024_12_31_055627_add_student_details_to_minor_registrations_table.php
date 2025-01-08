<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            // Add student details columns
            $table->string('name')->after('student_id');
            $table->string('matric_number')->after('name');
            $table->string('current_semester')->after('matric_number');
            $table->string('programme')->after('current_semester');
            $table->string('phone')->after('programme');
            $table->string('email')->after('phone');

            // Make sure other required columns exist
            if (!Schema::hasColumn('minor_registrations', 'course_id')) {
                $table->foreignId('course_id')->after('cgpa')->constrained();
            }

            if (!Schema::hasColumn('minor_registrations', 'signed_form_path')) {
                $table->string('signed_form_path')->nullable()->after('status');
            }

            if (!Schema::hasColumn('minor_registrations', 'recommendation_status')) {
                $table->string('recommendation_status')->nullable()->after('signed_form_path');
            }

            if (!Schema::hasColumn('minor_registrations', 'dean_comments')) {
                $table->text('dean_comments')->nullable()->after('recommendation_status');
            }

            if (!Schema::hasColumn('minor_registrations', 'dean_name')) {
                $table->string('dean_name')->nullable()->after('dean_comments');
            }

            if (!Schema::hasColumn('minor_registrations', 'dean_signature')) {
                $table->string('dean_signature')->nullable()->after('dean_name');
            }

            if (!Schema::hasColumn('minor_registrations', 'recommendation_date')) {
                $table->timestamp('recommendation_date')->nullable()->after('dean_signature');
            }
        });
    }

    public function down()
    {
        Schema::table('minor_registrations', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn([
                'name',
                'matric_number',
                'current_semester',
                'programme',
                'phone',
                'email'
            ]);

            // Drop other columns if they were added
            if (Schema::hasColumn('minor_registrations', 'course_id')) {
                $table->dropForeign(['course_id']);
                $table->dropColumn('course_id');
            }

            $table->dropColumn([
                'signed_form_path',
                'recommendation_status',
                'dean_comments',
                'dean_name',
                'dean_signature',
                'recommendation_date'
            ]);
        });
    }
};
