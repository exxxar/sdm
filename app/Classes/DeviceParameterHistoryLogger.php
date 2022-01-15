<?php

namespace App\Classes;

use App\Enums\ModelType;
use App\History;
use App\Http\Controllers\ProxiController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DeviceParametersHistory;
use App\Device;
use App\Events\ErrorTaskEvent;
use App\Models\DeviceParametersHistoryDaily;
use App\Services\DeviceCacheService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DeviceParameterHistoryLogger
{
    protected bool $debug;

    public function __construct()
    {
        $this->debug = false;
    }

    protected function prepareURL(string $ip, string $port, string $login, string $password, int $device_type_id, Carbon $startDate, Carbon $endDate): string
    {
        try {
            return ($this->debug ?
                    "http://81.200.248.156:3000" :
                    env('CAMERA_URL', 'http://192.168.68.8:3000'))
                . '/fullcaminfo?ip=' . $ip
                . ($port ? '&port=' . $port : '&port=80'  )
                . '&login=' . $login . '&password=' . $password
                . '&device_type=' . $device_type_id
                . '&start_time=' . $startDate->getTimestamp() . '000' //Carbon::now()->startOfDay()->addHours(3)->getTimestamp() . '000'///.
                . '&end_time=' . $endDate->getTimestamp() . '000'; //Carbon::now()->endOfDay()->addHours(3)->getTimestamp() . '000';

        } catch (Exception $e) {
            return "";
        }
    }

    protected function loadContent($url): object
    {
        ini_set('max_execution_time', '2700');
        ini_set('allow_url_fopen', 1);
        sleep(2);
        try {
            $content = (Http::timeout(15)->post($url))->object();
        } catch (Exception $e) {
            Log::info("Load content error");

            $content = (object)[
                "violations" => 0,
                "passages" => 0,
                "status" => "error",
                "ping" => 0,
                "voltage" > 0,
                "passages24" => 0,
                "violations24" => 0,
                "data" => null,
            ];
        }
        ini_set('max_execution_time', '60');
        return $content;
    }

    protected function kordonHelper(int $deviceId, object $content, Carbon $startDate, Carbon $endDate, $isDayly = false): DeviceParametersHistory
    {
        return $this->baseHelper($deviceId, $content, $startDate, $endDate, $isDayly);
    }

    protected function vakordHelper(int $deviceId, object $content, Carbon $startDate, Carbon $endDate, $isDayly = false): DeviceParametersHistory
    {
        return $this->baseHelper($deviceId, $content, $startDate, $endDate, $isDayly);
    }

    protected function baseHelper(int $deviceId, object $content, Carbon $startDate, Carbon $endDate, $isDayly = false): DeviceParametersHistory
    {
        return DeviceParametersHistory::create([
            'device_id' => $deviceId,
            'violations' => intval($content->violations ?? 0),
            'passages' => intval($content->passages ?? 0),
            'status' => $content->status ?? '',
            'ping' => intval($content->ping ?? 0),
            'voltage' => doubleval($content->voltage ?? 0),
            'additional_data' => isset($content->data) ? $content->data->getDeviceInfo : null,
            'created_at' => $isDayly ? $endDate->subSeconds(1) : Carbon::now()
        ]);

    }

    protected function orlanHelper(int $deviceId, object $content, Carbon $startDate, Carbon $endDate, $isDayly = false): DeviceParametersHistory
    {

        $endDate = $endDate->subSeconds(1);

        if (!$isDayly)
            return DeviceParametersHistory::create([
                'device_id' => $deviceId,
                'violations' => intval($content->violations ?? 0),
                'passages' => intval($content->passages ?? 0),
                'status' => $content->status ?? '',
                'ping' => intval($content->ping ?? 0),
                'voltage' => doubleval($content->voltage ?? 0),
                'additional_data' => isset($content->data) ? $content->data->getDeviceInfo : null,
                'created_at' => $isDayly ? $endDate: Carbon::now()
            ]);

        $dphs = DeviceParametersHistory::where("device_id", $deviceId)
            ->whereBetween("created_at", [
                $startDate->setHour(0)->setMinute(0)->setSecond(0),
                $endDate->setHour(23)->setMinute(59)->setSecond(58)
            ])->get();

/*
 *
 * SELECT * FROM `device_parameters_histories` WHERE `device_id` IN (5, 10, 11, 12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,77,83,96,98) AND `created_at` BETWEEN '2021-12-12 23:50:59' AND '2021-12-13 00:00:00' ORDER BY `id`  DESC
 */
        $passages = $dphs->sum("passages");
        $violations = $dphs->sum("violations");

        $dphs = DeviceParametersHistory::where("device_id", $deviceId)
            ->where("created_at", $endDate
                ->setHour(23)
                ->setMinute(59)
                ->setSecond(59)
            )
            ->get();

        if (count($dphs) > 0)
            foreach ($dphs as $dph)
                $dph->delete();


        $passages = abs(($content->passages24 ?? 0) - $passages);
        $violations = abs(($content->violations24 ?? 0) - $violations);


        return DeviceParametersHistory::create([
            'device_id' => $deviceId,
            'violations' => intval($violations ?? 0),
            'passages' => intval($passages ?? 0),
            'status' => $content->status ?? '',
            'ping' => intval($content->ping ?? 0),
            'voltage' => doubleval($content->voltage ?? 0),
            'additional_data' => isset($content->data) ? $content->data->getDeviceInfo : null,
            'created_at' => $endDate//->startOfDay()->setHour(23)->setMinute(59)->setSecond(59)
        ]);


    }

    public function getInfoByDeviceByPeriod($device, $startDate, $endDate, $isDayly = false): DeviceParametersHistory
    {

        $url = $this->prepareURL(
            $device->ip ?? '',
            $device->port ?? '',
            $device->login ?? '',
            $device->password ?? '',
            $device->device_type_id ?? 1,
            $startDate, $endDate);


        $parsedContent = $this->loadContent($url);

        Log::info("content=>" . print_r($parsedContent, true));
        $dph = null;

        switch ($device->device_type_id) {
            case 2:
                $dph = $this->kordonHelper($device->id, $parsedContent, $startDate, $endDate, $isDayly);
                $this->checkDeviceInfo($device, $parsedContent);

                break;
            case 3:
                $dph = $this->orlanHelper($device->id, $parsedContent, $startDate, $endDate, $isDayly);
                break;
            case 5:
                $dph = $this->vakordHelper($device->id, $parsedContent, $startDate, $endDate, $isDayly);
                break;
        }


        return $dph;


    }

    public function logHandler($isDayly = false)
    {

        $devices = Device::orderBy("id", "asc")->get();

        foreach ($devices as $device) {

            if ($device->device_type_id === 1) {
                continue;
            }


            try {
                if (!$isDayly) {
                    $startDate = Carbon::now()->startOfDay()->hours(0)->minute(0)->second(0);
                    $endDate = Carbon::now()->endOfDay()->hours(23)->minute(59)->second(59)->addSeconds(1);
                } else {
                    $startDate = Carbon::now()->subDay()->startOfDay()->hours(0)->minute(0)->second(0);
                    $endDate = Carbon::now()->subDay()->endOfDay()->hours(23)->minute(59)->second(59)->addSeconds(1);
                }

                $dph = $this->getInfoByDeviceByPeriod($device, $startDate, $endDate, $isDayly);

                if (!$device->is_alive) {

                    if ($device->is_active) {
                        // устройство не ответило трижды
                        event(new ErrorTaskEvent((object)[
                            "device_id" => $device->id,
                            "malfunction_id" => 4,
                            "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                            "custom_reason" => "Нет ответа от камеры",
                            "started_at" => Carbon::now()
                        ]));
                    }

                } else
                {

                    // утройство отвечает, проверяем заряд
                    $voltage = (floatval($dph->voltage) < 0) ? 13 : floatval($dph->voltage);

                    $chargePercentage = ($voltage / 13) * 100;

                    if ($chargePercentage < 20) {
                        // заряд меньше 20%
                        if ($device->is_active) {
                            event(new ErrorTaskEvent((object)[
                                "device_id" => $device->id,
                                "malfunction_id" => 3,
                                "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                                "custom_reason" => "У камеры осталось {$chargePercentage}% заряда",
                                "started_at" => Carbon::now()
                            ]));
                        };
                    }

                }
            } catch (Exception $e) {
                Log::info($e->getMessage() . "" . $e->getLine() . " device=>" . ($device->id ?? null));;
            }


        }

        // обновление кэша карты
        DeviceCacheService::cacheDevices();

    }

    public static function checkDeviceInfo(Device $device, object $content): void
    {

        if (!$device->is_active || isset(((array)$content)["error"])) {
            return;
        }


        try {

            $content = $content->data->getDeviceInfo;
            // проверка серийного номера
            if ($device->serial != "{$content->SERIAL_NUMBER}-{$content->BLOCK_NUMBER}") {
                // неверный серийный номер
                event(new ErrorTaskEvent((object)[
                    "device_id" => $device->id,
                    "malfunction_id" => 19,
                    "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                    "custom_reason" => "Неверный серийный номер",
                    "started_at" => Carbon::now()
                ]));
            }
        } catch (Exception $e) {
            Log::info("ERROR before check 1");
        }

        $deviceBoundary = $device->deviceBoundary;

        try {
            // проверка расположения устройства по названию рубежа
            if ($deviceBoundary) {
                if ($content->fixing->location != $deviceBoundary->title) {
                    // неверное расположение
                    event(new ErrorTaskEvent((object)[
                        "device_id" => $device->id,
                        "malfunction_id" => 20,
                        "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                        "custom_reason" => "Неверный рубеж",
                        "started_at" => Carbon::now()
                    ]));
                }
            } else {
                // не имеет рубежа
            }
        } catch (Exception $e) {
            Log::info("ERROR before check 2");
        }

        try {
            // проверка расположения устройства по координатам
            if ($device->lat && $device->lon) {

                $precision = 7;

                // значения из опроса
                $actualLat = round($content->GPS->lat, $precision);
                $actualLon = round($content->GPS->lon, $precision);

                //значения из базы
                $dbLat = round($device->lat, $precision);
                $dbLon = round($device->lon, $precision);

                if ($actualLat != $dbLat || $actualLon != $dbLon) {
                    // координаты из опроса не совпадают с теми, что в базе
                    event(new ErrorTaskEvent((object)[
                        "device_id" => $device->id,
                        "malfunction_id" => 21,
                        "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                        "custom_reason" => "Координаты из опроса не совпадают с теми, что в базе",
                        "started_at" => Carbon::now()
                    ]));
                }
            } else {
                // в базе нет координат устройства
            }
        } catch (Exception $e) {
            Log::info("ERROR before check 3");
        }
        try {
            // проверка сертификата
            $currentTime = Carbon::now()->getTimestamp();
            $lastCertificateCheck = $content->fixing->certificate->expire;

            if ($currentTime > $lastCertificateCheck) {
                // сертификат просрочен
                event(new ErrorTaskEvent((object)[
                    "device_id" => $device->id,
                    "malfunction_id" => 22,
                    "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                    "custom_reason" => "Сертификат просрочен",
                    "started_at" => Carbon::now()
                ]));
            } else {
                // оставшееся время
                $remainSeconds = $lastCertificateCheck - $currentTime;
                $remainDays = intval($remainSeconds / 86400);

                if ($remainDays <= 3) {
                    event(new ErrorTaskEvent((object)[
                        "device_id" => $device->id,
                        "malfunction_id" => 18,
                        "boundary_id" => $device->deviceBoundary ? $device->deviceBoundary->id : null,
                        "custom_reason" => "Сертификат будет просрочен через {$remainDays} дней",
                        "started_at" => Carbon::now()
                    ]));
                }
            }
        } catch (Exception $e) {
            Log::info("ERROR before check 4");
        }
    }
}
