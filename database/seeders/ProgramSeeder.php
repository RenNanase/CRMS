<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            // Faculty of Islamic Technology
            [
                'name' => ' Bachelor of Halal Technology and Compliance',
                'code' => 'BHTC',
                'faculty_id' => 1,

            ],
            [
                'name' => 'Bachelor of Islamic Cybersecurity ',
                'code' => 'BIC',
                'faculty_id' => 1,
                'description' => 'The Bachelor of Islamic Cybersecurity program is designed to equip students with the necessary skills to protect and secure Islamic digital assets. It covers topics such as Islamic cyber ethics, cyber law, and cybersecurity strategies. Graduates will be able to contribute to the development of a secure and compliant digital environment for Islamic institutions.',

            ],
            // Faculty of Arts
            [
                'name' => 'Bachelor of Fine Arts in Digital and Traditional Media',
                'code' => 'BFA-DTM',
                'faculty_id' => 2,
                'description' => 'The Bachelor of Fine Arts in Digital and Traditional Media program prepares students for careers in the creative industries, focusing on both digital and traditional media. It combines art theory with practical skills in digital and traditional media production. Graduates will be able to create innovative and culturally relevant media content for a global audience.',
            ],
            [
                'name' => 'Bachelor of Performing Arts in Traditional and Modern Theater',
                'code' => 'BPA-TMT',
                'faculty_id' => 2,
                'description' => 'The Bachelor of Performing Arts in Traditional and Modern Theater program prepares students for careers in the performing arts, focusing on both traditional and modern theater. It combines theater theory with practical skills in theater production. Graduates will be able to create innovative and culturally relevant theater content for a global audience.',
            ],
            [
                'name' => 'Bachelor of Arts in Creative Writing and Storytelling ',
                'code' => 'BACWS',
                'faculty_id' => 2,
                'description' => 'The Bachelor of Arts in Creative Writing and Storytelling program prepares students for careers in the creative industries, focusing on both creative writing and storytelling. It combines writing theory with practical skills in creative writing and storytelling. Graduates will be able to create innovative and culturally relevant writing and storytelling content for a global audience.',
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
