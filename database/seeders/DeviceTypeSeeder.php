<?php

namespace Database\Seeders;

use App\DeviceType;
use Illuminate\Database\Seeder;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DeviceType::factory()->count(5)->create();
        DeviceType::create([
            'title' => 'Роутер',
        ]);

        DeviceType::create([
            'title' => 'Камера (КОРДОН)',
        ]);

        DeviceType::create([
            'title' => 'Камера (ОРЛАН)',
        ]);

        DeviceType::create([
            'title' => 'Камера (ДЕКАРТ)',
        ]);

        DeviceType::create([
            'title' => 'Камера (ВОКОРД)',
        ]);
    }
}
