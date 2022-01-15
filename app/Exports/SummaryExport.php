<?php

namespace App\Exports;

use App\Exports\ReportExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;

class SummaryExport implements WithMultipleSheets
{
    use Exportable;
    private $history_grouped_by_date, $history_grouped_by_device;

    public function __construct(array $history_grouped_by_date, array $history_grouped_by_device)
    {
        $this->history_grouped_by_date = $history_grouped_by_date;
        $this->history_grouped_by_device = $history_grouped_by_device;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheet = new ReportExport($this->history_grouped_by_date, $this->history_grouped_by_device, 'passages');
        array_push($sheets, $sheet);
        $sheet = new ReportExport($this->history_grouped_by_date, $this->history_grouped_by_device, 'violations');
        array_push($sheets, $sheet);
        $sheet = new ReportExport($this->history_grouped_by_date, $this->history_grouped_by_device, 'voltage');
        array_push($sheets, $sheet);

        return $sheets;
    }
}
