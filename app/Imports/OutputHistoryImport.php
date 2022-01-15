<?php

namespace App\Imports;

use App\Device;
use App\DeviceParametersHistory;
use App\Dictionary;
use App\DictionaryType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;

class OutputHistoryImport implements ToModel, WithBatchInserts, WithChunkReading
{
    use RemembersRowNumber;

    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        $split = explode(" ", $row[1]);

        $device = Device::where("serial", $row[1])
            ->orWhere("serial", ($split[0]??'') . "-" . ($split[1]??''))
            ->first();



        if (is_null($device))
            return;


        $isAdded = DeviceParametersHistory::where("created_at",$row[0])
            ->where("device_id",$device->id)
            ->first();

        if (!is_null($isAdded))
            return;

        try {
            return new DeviceParametersHistory([
                'device_id' => $device->id,
                'violations' => $row[2] ?? 0,
                'passages' => $row[3] ?? 0,
                'status' => 'active',
                'ping' => 0,
                'voltage' => 0,
                'created_at' => new Carbon($row[0]),
            ]);
        } catch (\Exception $e) {
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

}

/*implements OnEachRow
{
public function onRow(Row $row)
{
    $rowIndex = $row->getIndex();
    $row = $row->toArray();



    if ($rowIndex == 1)
        return null;



    try {
        $split = explode(" ", $row[1]);

        $device = Device::where("serail", $row[1])
            ->orWhere("serail", $split[0] . "-" . $split[1])
            ->first();



        if (is_null($device))
            return;

        Log::info($device->serial);


        DeviceParametersHistory::create([
            'device_id' => $device->id,
            'violations' => $row[2] ?? 0,
            'passages' => $row[3] ?? 0,
            'status' => 'active',
            'ping' => 0,
            'voltage' => 0,
            'created_at' => new Carbon($row[0]),
        ]);
    } catch (\Exception $e) {
    }
}
}

*/

