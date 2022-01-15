<?php

namespace App\Exports;

use App\BoundarySchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BoundaryScheduleMovableExport implements FromView, ShouldAutoSize
{
    private $table;
    private $dates;
    private $boundaries;


    public function __construct($table, $dates, $boundaries)
    {

        $this->table = $table;
        $this->dates = $dates;
        $this->boundaries = $boundaries;

    }

    public function view(): View
    {
        $titles = [];
        foreach ($this->boundaries as $boundary)
            array_push($titles, "[#".$boundary->id."]".$boundary->title);

        return view('exports.schedule.movable', [
            'heading' => $titles,
            'table'=>$this->table
        ]);
    }
}
