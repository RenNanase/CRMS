<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersRoleEnum extends Migration
{
    public function up()
    {
        // Convert ENUM to VARCHAR temporarily
        DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(255)");

        // Convert back to ENUM with new values
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Student', 'program_head', 'faculty_dean', 'offering_faculty', 'lecturer') DEFAULT 'Student'");
    }

    public function down()
    {
        // Revert back to original ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Student', 'program_head', 'faculty_dean', 'offering_faculty') DEFAULT 'Student'");
    }
}
