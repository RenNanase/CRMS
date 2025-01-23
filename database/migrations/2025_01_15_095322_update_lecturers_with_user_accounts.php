<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lecturer;
use App\Models\User;

class UpdateLecturersWithUserAccounts extends Migration
{
    public function up()
    {
        // First, ensure the user_id column exists
        if (!Schema::hasColumn('lecturers', 'user_id')) {
            Schema::table('lecturers', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable();
            });
        }

        // Create user accounts for existing lecturers
        $lecturers = Lecturer::all();

        foreach ($lecturers as $lecturer) {
            // Check if a user with this email already exists
            $existingUser = User::where('email', $lecturer->email)->first();

            if (!$existingUser) {
                // Create new user account
                $user = User::create([
                    'name' => $lecturer->name,
                    'email' => $lecturer->email,
                    'password' => bcrypt('lect123@'),
                    'role' => 'lecturer',
                    'role_id' => 3
                ]);

                // Update lecturer with user_id
                $lecturer->user_id = $user->id;
                $lecturer->save();
            } else {
                // If user exists, just link it
                $lecturer->user_id = $existingUser->id;
                $lecturer->save();
            }
        }

        // Add foreign key constraint
        Schema::table('lecturers', function (Blueprint $table) {
            try {
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            } catch (\Exception $e) {
                // Foreign key might already exist, continue
            }
        });
    }

    public function down()
    {
        Schema::table('lecturers', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Foreign key might not exist
            }

            if (Schema::hasColumn('lecturers', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}
