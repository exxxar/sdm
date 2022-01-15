<?php

namespace Database\Seeders;

use App\Boundary;
use App\BoundarySchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BoundaryScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        BoundarySchedule::truncate();

        Boundary::create([
            'title' => "TEST MOVABLE",
            'speed_mode' => 50,
            'mobile' => true,
            'movable' => true,


        ]);

        Boundary::create([
            'title' => "TEST STATIC",
            'speed_mode' => 50,
            'mobile' => false,
            'movable' => false,
        ]);

        $boundaries = Boundary::all();

        $days = 1;
        foreach ($boundaries as $boundary) {
            $date = Carbon::now()->subDays($days);

            BoundarySchedule::create([
                "type" => $boundary->movable ? 1 : 0,
                "start_at" => Carbon::parse("$date->day.$date->month.$date->year 00:00"),
                "end_at" => Carbon::parse("$date->day.$date->month.$date->year 23:59"),
                "boundary_id" => $boundary->id,
                "is_installed" => false,
                "address"=>"",
            ]);

            $days++;
        }
    }
}
