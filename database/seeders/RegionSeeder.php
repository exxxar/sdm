<?php

namespace Database\Seeders;

use App\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::factory()->count(5)->create();

        $arr = ["Железнодорожный","Ленинский", "Октябрьский", "Первомайский" ];

        foreach ($arr as $region)
            Region::create([
               "title"=>$region
            ]);
    }
}
