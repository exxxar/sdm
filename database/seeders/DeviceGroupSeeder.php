<?php

namespace Database\Seeders;

use App\DeviceGroup;
use Illuminate\Database\Seeder;

class DeviceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeviceGroup::factory()->count(5)->create();
    }
}
