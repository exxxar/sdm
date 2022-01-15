<?php

namespace Database\Seeders;

use App\Boundary;
use Illuminate\Database\Seeder;

class BoundarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boundary::factory()->count(5)->create();
    }
}
