<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hall::create([
            'name' => 'Ki Hajar',
            'description' => '',
        ]);

        Hall::create([
            'name' => 'Kartini',
            'description' => '',
        ]);
    }
}
