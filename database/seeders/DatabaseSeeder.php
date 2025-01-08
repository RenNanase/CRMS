<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        //create admin user
        // User::factory()->create([
        //     'name' => 'Ren Nanase',
        //     'email' => 'renNanase@gmail.com',
        //     'role' => 'admin',
        //     'password' =>bcrypt('renNanase123'),
        // ]);

        $this->call(FacultySeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(ProgramStructureSeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
