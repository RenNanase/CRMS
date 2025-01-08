<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Program;
class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create 50 sample students
        for ($i = 0; $i < 2; $i++) {
            // Create a user first (assuming you have a User model)
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), // Default password for all seeded users
            ]);

            Student::create([
                'name' => $user->name,
                'email' => $user->email,
                'matric_number' => 'M' . $faker->unique()->numberBetween(10000, 99999),
                'program_id' => $faker->randomElement(Program::all()->pluck('id')),
                'program_name' => $faker->randomElement(Program::all()->pluck('name')),
                'program_code' => $faker->randomElement(Program::all()->pluck('code')),
                'ic_number' => $faker->numberBetween(900101, 050101) . $faker->unique()->numberBetween(10000, 99999),
                'current_semester' => $faker->numberBetween(1, 8),
                'phone' => $faker->phoneNumber,
                'academic_year' => '2023/2024',
                'batch' => $faker->randomElement(['A', 'B', 'C']),
                'intake' => $faker->randomElement(['January 2023', 'June 2023', 'September 2023']),
                'address' => $faker->address,
                'user_id' => $user->id,
                'scholarship_status' => $faker->randomElement(['None', 'Full', 'Partial']),
                'photo' => null, // You can add default photo path if needed
            ]);
        }
    }
}
