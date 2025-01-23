<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UpdateLecturerPassword extends Migration
{
    public function up()
    {
        // Update password for the lecturer
        DB::table('users')
            ->where('email', 'karina@unissa.bn.edu')
            ->update([
                'password' => Hash::make('password123') // Change this to your desired password
            ]);
    }

    public function down()
    {
        // No need for down method as we don't want to store old passwords
    }
}
