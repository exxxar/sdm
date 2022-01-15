<?php

namespace App\Http\Controllers;

use App\Classes\DeviceParameterHistoryLogger;
use App\Classes\OperationHistory;
use App\Device;
use App\DeviceParametersHistory;
use App\Enums\ModelType;
use App\Events\ErrorTaskEvent;
use App\History;
use App\Jobs\RemoveImageJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProxiController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function getInfoEveryHour(Request $request)
    {
        (new DeviceParameterHistoryLogger())->logHandler(false);

        return response()->noContent();
    }

    public function getInfoDayly(Request $request)
    {
        (new DeviceParameterHistoryLogger())->logHandler(true);

        return response()->noContent();
    }

    public function getDeviceInfo(Request $request, Device $device)
    {

        try {

            $day_before_start = Carbon::now()->subDay()->startOfDay()->setHour(23)->setMinute(0)->setSecond(0) ?? null;
            $day_before_end = Carbon::now()->subDay()->endOfDay()->setHour(23)->setMinute(59)->setSecond(59)->addSeconds(1) ?? null;


            $dph = (new DeviceParameterHistoryLogger())->getInfoByDeviceByPeriod($device, $day_before_start, $day_before_end);

            return response()->json([
                "passages" => $dph->passages ?? 0,
                "violations" => $dph->violations ?? 0,
                "status" => $dph->status ?? 'Error',
                "ping" => $dph->ping ?? 0
            ]);

        } catch (Exception $e) {
            return response()->json([
                "passages" => 0,
                "violations" => 0,
                "status" => "Error",
                "ping" => 0]);
        }

    }


    public function getCurrentDeviceInfo(Request $request, Device $device)
    {

        try {
            $day_before_start = Carbon::now()->startOfHour() ?? null;
            $day_before_end = Carbon::now()->endOfHour() ?? null;

            $dph = (new DeviceParameterHistoryLogger())->getInfoByDeviceByPeriod($device, $day_before_start, $day_before_end);

            return response()->json([
                "passages" => $dph->passages ?? 0,
                "violations" => $dph->violations ?? 0,
                "status" => $dph->status ?? 'Error',
                "ping" => $dph->ping ?? 0
            ]);

        } catch (Exception $e) {
            return response()->json([
                "passages" => 0,
                "violations" => 0,
                "status" => 'Error',
                "ping" => 0
            ]);
        }

    }

    public function correctDeviceInfoByDate(Request $request)
    {
        $request->validate([
            "date" => "required"
        ]);


        $dateStart = Carbon::parse(str_replace(".", "-", $request->date) . " 00:00:00");
        $dateEnd = Carbon::parse(str_replace(".", "-", $request->date) . " 23:59:59")->addSeconds(1);

        $result = [];
        try {

            $devices = Device::all();

            foreach ($devices as $device) {

                $dph = (new DeviceParameterHistoryLogger())->getInfoByDeviceByPeriod($device, $dateStart, $dateEnd, true);
                array_push($result, $dph);
            }

        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ]);
        }

        return response()->json($result);

    }

    public function openDevice(Request $request)
    {
        $request->validate([
            "serial" => "required",
        ]);

        $device = Device::where("serial", $request->serial)->first();

        return response()->json(["id"=>$device->id]);

    }

    public function correctDeviceInfoById(Request $request)
    {

        $request->validate([
            "date" => "required",
            "serial" => "required",
        ]);


        $dateStart = Carbon::parse(str_replace(".", "-", $request->date) . " 00:00:00");
        $dateEnd = Carbon::parse(str_replace(".", "-", $request->date) . " 23:59:59")->addSeconds(1);


        Log::info($dateStart . " " . $dateEnd);
        try {

            $device = Device::where("serial", $request->serial)->first();

            $dph = (new DeviceParameterHistoryLogger())->getInfoByDeviceByPeriod($device, $dateStart, $dateEnd, false);


        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "line" => $e->getLine(),
            ]);
        }

        if ($device->device_type_id === 3) {
            $dphs = DeviceParametersHistory::where("device_id", $device->id)
                ->whereBetween("created_at", [
                    $dateStart,//->setHour(0)->setMinute(0)->setSecond(0),
                    $dateEnd,//->setHour(23)->setMinute(59)->setSecond(58)
                ])->get();


            $passages = $dphs->sum("passages");
            $violations = $dphs->sum("violations");
            $ping = $dphs->avg("ping");
            $voltage = $dphs->avg("voltage");

            return response()->json((object)[
                'violations' => $violations,
                'passages' => $passages,
                'status' => 'active',
                'ping' => $ping,
                'voltage' => $voltage,
            ]);
        } else
            return response()->json($dph);

    }

    public function getDeviceInfoWithCheck(Device $device)
    {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
            ),
        ));

        if ($device->device_type_id === 1) {
            return "router";
        }

        try {
            $content = file_get_contents(
                $file = 'http://81.200.248.156:3000/fullcaminfo?ip=' . $device->ip . (($device->port) ? '&port=' . $device->port : '') . '&login=' . $device->login . '&password=' . $device->password . '&device_type=' . $device->device_type_id . '&start_time=' . Carbon::now()->subHour()->getTimestamp() . '000' . '&end_time=' . Carbon::now()->getTimestamp() . '000',
                $use_include_path = false,
                $context
            );

            $parsedContent = json_decode($content);

            if ($device->device_type_id === 2) {
                $deviceInfo = $parsedContent->data->getDeviceInfo;

                $this->checkDeviceInfo($device, $deviceInfo);
            }
        } catch (ErrorException $e) {
            return $e;
        }
    }

    private
    function checkDeviceInfo(Device $device, object $content): void
    {
        // проверка серийного номера
        if ($device->serial != "{$content->SERIAL_NUMBER}-{$content->BLOCK_NUMBER}") {
            // неверный серийный номер
            event(new ErrorTaskEvent(
                $device->id,
                6,
                $device->boundary ? $device->boundary->id : null,
                5,
                5,
                Carbon::now(),
                null,
                null,
                null,
                null,
                "Актуальные",
                "Неверный серийный номер",
                null
            ));
        }

        $deviceBoundary = $device->deviceBoundary;

        // проверка расположения устройства по названию рубежа
        if ($deviceBoundary) {
            if ($content->fixing->location != $deviceBoundary->title) {
                // неверное расположение
                event(new ErrorTaskEvent(
                    $device->id,
                    6,
                    $device->boundary ? $device->boundary->id : null,
                    5,
                    5,
                    Carbon::now(),
                    null,
                    null,
                    null,
                    null,
                    "Актуальные",
                    "Неверное расположение",
                    null
                ));
            }
        } else {
            // не имеет рубежа
        }

        // проверка расположения устройства по координатам
        if ($device->lat && $device->lon) {

            $precision = 2;

            // значения из опроса
            $actualLat = round($content->GPS->lat, $precision);
            $actualLon = round($content->GPS->lon, $precision);

            //значения из базы
            $dbLat = round($device->lat, $precision);
            $dbLon = round($device->lon, $precision);

            if ($actualLat != $dbLat || $actualLon != $dbLon) {
                // координаты из опроса не совпадают с теми, что в базе
                event(new ErrorTaskEvent(
                    $device->id,
                    6,
                    $device->boundary ? $device->boundary->id : null,
                    5,
                    5,
                    Carbon::now(),
                    null,
                    null,
                    null,
                    null,
                    "Актуальные",
                    "Координаты из опроса не совпадают с теми, что в базе",
                    null
                ));
            }
        } else {
            // в базе нет координат устройства
        }

        // проверка сертификата
        $currentTime = Carbon::now()->getTimestamp();
        $lastCertificateCheck = $content->fixing->certificate->expire;

        if ($currentTime > $lastCertificateCheck) {
            // сертификат просрочен
            event(new ErrorTaskEvent(
                $device->id,
                6,
                $device->boundary ? $device->boundary->id : null,
                5,
                5,
                Carbon::now(),
                null,
                null,
                null,
                null,
                "Актуальные",
                "Сертификат просрочен",
                null
            ));
        } else {
            // оставшееся время
            $remainSeconds = $lastCertificateCheck - $currentTime;
            $remainDays = intval($remainSeconds / 86400);
        }
    }

    public
    function getImageFromCamera(Device $device)
    {
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: image/jpeg',
            ),
        ));

        try {
            ini_set('default_socket_timeout', 10);
            $content = file_get_contents(
                $file = "http://192.168.68.8:3000/video?login=" . $device->login . "&start_time=1612818000&ip=" . $device->ip . "&password=" . $device->password . "&end_time=1612991239&device_type=" . $device->device_type_id,
                $use_include_path = false,
                $context
            );

            $filename = time() . ".jpg";

            Storage::put("public/img/" . $filename, $content);
            RemoveImageJob::dispatch("public/img/" . $filename)->delay(now()->addSeconds(60));
            ini_set('default_socket_timeout', 60);
            return '/storage/img/' . $filename;
        } catch (Exception $e) {
            ini_set('default_socket_timeout', 60);
            abort(500, $e->getMessage());
        }
    }
}
