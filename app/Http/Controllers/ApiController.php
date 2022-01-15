<?php

namespace App\Http\Controllers;

use App\Classes\GismeteoAPI;
use App\Classes\PogodaIKlimatAPI;
use App\Device;
use App\DeviceParametersHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    protected $gismeteo;

    protected $pogodaiklimat;

    public function __construct()
    {
        $this->gismeteo = new GismeteoAPI();
        $this->pogodaiklimat = new PogodaIKlimatAPI();
    }

    public function indexV1($region_id, $year, $month)
    {
        try {
            return response()->json($this->gismeteo->oneMonthAPI($region_id, $year, $month));
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            return response()->json([
                "message" => "Ошибка параметров запроса"
            ]);
        }
    }

    public function indexV2($region_id, $year, $month)
    {
        try {
            return response()->json($this->pogodaiklimat->oneMonthAPI($region_id, $year, $month));
        } catch (\Exception $ex) {
            Log::info($ex->getMessage());
            return response()->json([
                "message" => "Ошибка параметров запроса"
            ]);
        }
    }

    public function dictionariesV1()
    {
        return response()->json([
            "cloudy" => $this->gismeteo->getCloudyDictionary(),
            "wind" => $this->gismeteo->getWindDictionary(),
            "precipitation" => $this->gismeteo->getPrecipitationDictionary()
        ]);
    }


    public function dictionariesV2()
    {
        return response()->json($this->pogodaiklimat->getFullDescription());
    }


    public function getPolls(Request $request)
    {
        /*Получение списка всех отчётов с камер, а так же устройств с
которых они были сделаны с настройками этих устройств: */
        $request->validate([
            "id" => "required"
        ]);

     /*   DeviceParametersHistory::
        'device_id',
        'violations',
        'passages',
        'status',
        'ping',
        'voltage',
        'additional_data',
        'created_at'*/


    /*    Device:
        'serial',
        'ip',
        'device_group_id',
        'device_boundary_id',
        'lat',
        'lon',
        'location_id',
        'device_type_id',
        'region_id',
        'connection',
        'port',
        'login',
        'password',
        'secret',
        'installation_date',
        'withdrawal_date',
        'deleted_at',
        'properties',
        'mobile',
        'is_active',
        'movable'*/

/*        Device append fields:
           "passages_day", "violations_day",
        "passages", "violations",
        "is_alive", "ping"*/

        /*Task:
        'boundary_id',
        'device_id',
        'malfunction_id',
        'user_id',
        'responsible_id',
        'started_at',
        'executed_at',
        'note',
        'notes',
        'deleted_at',
        'status',
        'custom_reason',
        'report_id'*/

        $tmp = [
            (object)[
                "DevicePollCreatedAt" => "2020-11-06 1:17:20",
                "DevicePollViolationQty" => 20,
                "DevicePollTransitQty" => 30,
                "DeviceSerial" => "М20547К",
                "DeviceActive" => true,
                "DeviceProperties" => "{ speed_mode: 60}",
                "DeviceId" => 1,
                "DeviceType" => "КОРДОН",
                "DeviceBoundary" => "Северный",
                "DeviceBoundaryLat" => 54.2,
                "DeviceBoundaryLon" => 40.1,
                "DeviceBoundaryActive" => true,
                "DeviceBoundaryId" => 1,
                "DevicePollId" => 1,
                "DeviceCreated" => "2020-11-06 1:17:20",
                "DeviceDeleted" => "2020-11-06 1:17:20",
                "DeviceMobile" => true,
                "DeviceAdresses" => ["Первомайская 25"],
                "DeviceBoundaryViolations" => ["Превышение скорости"]]
        ];

        return response()->json($tmp);
    }

    public function getPoll(Request $request)
    {

        /*Получение отчёта с камер по заданому id, а так же устройств с
которых они были сделаны с настройками этих устройств:*/
        $request->validate([
            "id" => "required"
        ]);

        $tmp = [
            (object)[
                "DevicePollCreatedAt" => "2020-11-06 1:17:20",
                "DevicePollViolationQty" => 20,
                "DevicePollTransitQty" => 30,
                "DeviceSerial" => "М20547К",
                "DeviceActive" => true,
                "DeviceProperties" => "{ speed_mode: 60}",
                "DeviceId" => 1,
                "DeviceType" => "КОРДОН",
                "DeviceBoundary" => "Северный",
                "DeviceBoundaryLat" => 54.2,
                "DeviceBoundaryLon" => 40.1,
                "DeviceBoundaryActive" => true,
                "DeviceBoundaryId" => 1,
                "DevicePollId" => 1,
                "DeviceCreated" => "2020-11-06 1:17:20",
                "DeviceDeleted" => "2020-11-06 1:17:20",
                "DeviceMobile" => true,
                "DeviceAdresses" => ["Первомайская 25"],
                "DeviceBoundaryViolations" => ["Превышение
скорости"]]

        ];
        return response()->json($tmp);
    }

    public function getPollsId(Request $request)
    {
        /*Получение списка всех id отчётов устройств: */
        $list = [1,2,15,126];
        return response()->json([
            "IdList"=>$list
        ]);
    }

}
