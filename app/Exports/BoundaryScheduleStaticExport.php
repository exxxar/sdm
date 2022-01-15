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

class BoundaryScheduleStaticExport implements FromView, ShouldAutoSize
{

    private $table;


    public function __construct($table)
    {

        $this->table = $table;
    }

    public function view(): View
    {
        return view('exports.schedule.static', [
            'table'=>$this->table
        ]);
    }
}
