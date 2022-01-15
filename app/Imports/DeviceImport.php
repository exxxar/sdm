<?php

namespace App\Imports;

use App\Classes\OperationHistory;
use App\Device;
use App\Dictionary;
use App\DictionaryType;
use App\Enums\ModelType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class DeviceImport implements OnEachRow
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

        $device = Device::create([
            'serial' => $row[0],
            'ip' => $row[1] ?? '',
            'device_group_id' => $row[2] ?? null,
            'device_boundary_id' => $row[3] ?? null,
            'lat' => $row[4] ?? null,
            'lon' => $row[5] ?? null,
            'device_type_id' => $row[6],
            'region_id' => $row[7] ?? null,
            'connection' => $row[8] ?? null,
            'port' => $row[9] ?? null,
            'login' => $row[10],
            'password' => $row[11],
            'secret' => $row[12],
            'installation_date' => $row[13] ?? null,
            'withdrawal_date' => $row[14] ?? null,
            'properties' => $row[15] ?? null,
            'mobile' => $row[16] ?? false,
            'is_active' => $row[17] ?? true,
            'movable' => $row[18] ?? false,
            'location_id' => null,
            'deleted_at' => null,
        ]);

        $this->setAfter((object)$device);
        $this->saveHistory("Загрузка из файла", ModelType::Device);
    }
}

