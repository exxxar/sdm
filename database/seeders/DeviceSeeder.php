<?php

namespace Database\Seeders;

use App\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Device::factory()->count(5)->create();
        Device::create([
            'serial' => 'KORDON_1',
            'ip' => '192.168.72.11',
            'device_type_id' => 2,
            'login' => 'admin',
            'password' => 'Fk5bu8jG',
            'secret' => 'secret',
            'mobile' => false,
            'movable' => false,
            'is_active' => true
        ]);

        Device::create([
            'serial' => 'KORDON_2',
            'ip' => '192.168.73.5',
            'device_type_id' => 2,
            'login' => 'admin',
            'password' => '8aHrgDKW',
            'secret' => 'secret',
            'mobile' => false,
            'movable' => false,
            'is_active' => true
        ]);

        Device::create([
            'serial' => 'VOKORD_1',
            'ip' => '192.168.40.26',
            'device_type_id' => 5,
            'login' => 'admin',
            'password' => '123456',
            'secret' => 'secret',
            'mobile' => false,
            'movable' => false,
            'is_active' => true
        ]);

        Device::create([
            'serial' => 'IPZ_1',
            'ip' => '172.19.58.27',
            'device_type_id' => 4,
            'login' => 'root',
            'password' => 'root',
            'secret' => 'secret',
            'mobile' => false,
            'movable' => false,
            'is_active' => true
        ]);

        Device::create([
            'serial' => 'ORLAN_1',
            'ip' => '192.168.73.4',
            'device_type_id' => 3,
            'login' => 'OrlanUser',
            'password' => 'OrlanPassword',
            'secret' => 'secret',
            'mobile' => false,
            'movable' => false,
            'is_active' => true
        ]);
    }
}
