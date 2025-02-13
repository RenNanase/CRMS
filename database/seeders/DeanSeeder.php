<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeanSeeder extends Seeder
{
    public function run(): void
    {
        // First, create a faculty
        $faculty = Faculty::create([
            'faculty_name' => 'Faculty of Islamic Technology',
            'faculty_code' => 'FIT'
        ]);

        // Then create the dean user
        $deanRole = Role::where('name', 'dean')->first();

        User::create([
            'name' => 'Haruka',
            'email' => 'haruka@gmail.com',
            'password' => Hash::make('haruka123@'),
            'role_id' => $deanRole->id,
            'faculty_id' => $faculty->id
        ]);
    }
}
