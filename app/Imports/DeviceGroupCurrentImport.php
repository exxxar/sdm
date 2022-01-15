<?php

namespace App\Imports;

use App\Classes\OperationHistory;
use App\DeviceGroup;
use App\Enums\ModelType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;

class DeviceGroupCurrentImport implements OnEachRow
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

        $device_group = DeviceGroup::create([
            'title'     => $row[0],
            'description'    => $row[1],
        ]);

        $this->setAfter((object)$device_group);
        $this->saveHistory("Импорт текущией группы устройств", ModelType::DeviceGroup);
    }
}
