<?php

namespace App\Imports;

use App\BoundaryGroup;
use App\Classes\OperationHistory;
use App\DeviceGroup;
use App\Dictionary;
use App\Enums\ModelType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class BoundaryGroupImport implements OnEachRow
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

        $boundary_group = BoundaryGroup::create([
            'title'     => $row[0],
            'description'    => $row[1],
        ]);

        $this->setAfter((object)$boundary_group);
        $this->saveHistory("Импорт группы рубежей", ModelType::BoundaryGroup);
    }
}



