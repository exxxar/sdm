<?php

namespace App\Imports;

use App\Boundary;
use App\BoundaryGroup;
use App\Classes\OperationHistory;
use App\Enums\ModelType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class BoundaryImport implements OnEachRow
{
    use OperationHistory;

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        if ($rowIndex == 1)
            return null;


        if ($row[0] == '')
            return;

        $boundary = Boundary::create([
            'title' => $row[0],
            'boundary_group_id' => $row[1] ?? null,
            'region_id' => $row[2] ?? null,
            'speed_mode' => $row[4],
            'lat' => $row[5] ?? null,
            'lon' => $row[6] ?? null,
            'mobile' => $row[7] ?? false,
            'is_active' => $row[8] ?? true,
            'movable' => $row[9] ?? false,
        ]);

        $this->setAfter((object)$boundary);
        $this->saveHistory("Импорт рубежей", ModelType::Boundary);
    }
}





