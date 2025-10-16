<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'video',
            'value' => 'https://www.youtube.com/embed/RbvaLbX1JVg?si=YhfRCvVUan1IOuDs',
        ]);
    }
}
