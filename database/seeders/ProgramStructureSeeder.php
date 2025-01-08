<?php

namespace Database\Seeders;

use App\Models\ProgramStructure;
use Illuminate\Database\Seeder;

class ProgramStructureSeeder extends Seeder
{
    public function run()
    {
        $structures = [
            [
                'program_name' => 'Bachelor of Computer Science',
                'faculty_id' => 1, // Make sure this faculty_id exists
                'pdf_path' => 'program-structures/bcs-structure.pdf',
                'academic_year' => '2023/2024',
                'version' => '1.0',
                'is_active' => true,
            ],
            [
                'program_name' => 'Bachelor of Information Technology',
                'faculty_id' => 1, // Make sure this faculty_id exists
                'pdf_path' => 'program-structures/bit-structure.pdf',
                'academic_year' => '2023/2024',
                'version' => '1.0',
                'is_active' => true,
            ],
            // Add more program structures as needed
        ];

        foreach ($structures as $structure) {
            ProgramStructure::create($structure);
        }
    }
}
