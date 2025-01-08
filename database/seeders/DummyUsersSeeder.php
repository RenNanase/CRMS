<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DummyUsersSeeder extends Seeder
{

    public function run(): void
    {
        $userData = [
            // [
            //     'name' => 'Dhazriana',
            //     'email' => 'admin@gmail.com',
            //     'role' => 'admin',
            //     'password' =>bcrypt('admin123'),
            // ],
            // [
            //     'name' => 'Ren',
            //     'email' => 'jellyfish@gmail.com',
            //     'role' => 'student',
            //     'password' =>bcrypt('Jfish123@'),
            // ],




            //can add more users

        ];

        foreach($userData as $key => $val) {
           User::create($val);
        }
    }
}
