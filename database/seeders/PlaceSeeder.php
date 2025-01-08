<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    public function run()
    {
        Place::create(['name' => 'Jubli Hall (400)']);
        Place::create(['name' => 'Computer Lab 1 (30)']);
        Place::create(['name' => 'Computer Lab 2 (30)']);
        Place::create(['name' => 'Computer Lab Sinaut']);
        Place::create(['name' => 'M 1.4 (36)']);
        Place::create(['name' => 'M 1.5 (72)']);
        Place::create(['name' => 'M 1.6 (22)']);
        Place::create(['name' => 'M 1.14 (36)']);
        Place::create(['name' => 'N 1.1 (132)']);
        Place::create(['name' => 'N 1.2 (24)']);
        Place::create(['name' => 'N 1.3 (24)']);
        Place::create(['name' => 'N 1.5 (48)']);
        // Add more places as needed
    }
}
