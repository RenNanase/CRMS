<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Course; // Import Course model

class GroupSeeder extends Seeder
{
    public function run()
    {
        // Fetch all courses
        $courses = Course::all();

        // Loop through each course and create groups A-G
        foreach ($courses as $course) {
            $groupNames = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            foreach ($groupNames as $groupName) {
                Group::create([
                    'group_name' => $groupName,
                    'course_id' => $course->id, // Associate with the course
                    'capacity' => 30, // Set the capacity for each group
                    'current_enrollment' => 0, // Initialize current enrollment
                ]);
            }
        }
    }
}