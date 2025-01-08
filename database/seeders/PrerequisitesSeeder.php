<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class PrerequisitesSeeder extends Seeder
{
    public function run()
    {
        // Create some courses if they don't already exist
        $course1 = Course::firstOrCreate([
            'course_name' => 'Basic Mathematics',
            'course_code' => 'MATH101',
            'credit_hours' => 3,
            'faculty_id' => 1, // Assuming you have a faculty with ID 1
        ]);

        $course2 = Course::firstOrCreate([
            'course_name' => 'Advanced Mathematics',
            'course_code' => 'MATH201',
            'credit_hours' => 3,
            'faculty_id' => 1,
        ]);

        // Setting prerequisites
        $course2->prerequisites()->attach($course1->id); // Attach Basic Mathematics as a prerequisite for Advanced Mathematics
    }
}