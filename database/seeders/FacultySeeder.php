<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty; // Make sure to import the Faculty model

class FacultySeeder extends Seeder
{
    public function run()
    {
        // List of faculties to be added
        $faculties = [
            ['faculty_name' => 'Faculty of Science'],
            ['faculty_name' => 'Faculty of Arts'],
            ['faculty_name' => 'Faculty of Engineering'],
            ['faculty_name' => 'Faculty of Business'],
            ['faculty_name' => 'Faculty of Medicine'],
            // Add more faculties as needed
        ];

        // Insert faculties into the database
        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }
}