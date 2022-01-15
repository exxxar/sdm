<?php

namespace Database\Seeders;

use App\BoundaryGroup;
use Illuminate\Database\Seeder;

class BoundaryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoundaryGroup::factory()->count(5)->create();
    }
}
