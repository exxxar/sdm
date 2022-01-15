<?php

namespace App\Services;

use App\Device;

class DeviceCacheService
{
    public static function cacheDevices() : void
    {
        ini_set('max_execution_time', '36000');
        $devices = Device::with(['appeals', 'deviceBoundary', 'deviceCoordsHistory', 'deviceParametersHistory'])->get();
        file_put_contents(storage_path('data/devices.json'), json_encode($devices));
        ini_set('max_execution_time', '60');
    }

    public static function getCachedDevices() : string
    {
        return file_get_contents(storage_path('data/devices.json'));
    }
}