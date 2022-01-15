<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/devices/info-date-correct', [App\Http\Controllers\ProxiController::class, 'correctDeviceInfoByDate'])->name('devices.info-date-correct');
Route::post('/devices/info-device-correct', [App\Http\Controllers\ProxiController::class, 'correctDeviceInfoById'])->name('devices.info-device-correct');
Route::get('/devices/info-every-hour', [App\Http\Controllers\ProxiController::class, 'getInfoEveryHour'])->name('devices.info-every-hour');
Route::get('/devices/info-dayly', [App\Http\Controllers\ProxiController::class, 'getInfoDayly'])->name('devices.info-dayly');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::apiResource('device-type', 'DeviceTypeController');
//Route::apiResource('region', 'RegionController');
//Route::apiResource('boundary', 'BoundaryController');
//Route::apiResource('device', 'DeviceController');
//Route::apiResource('task-status', 'TaskStatusController');
//Route::apiResource('task', 'TaskController');


Route::group(["prefix" => "v1"], function () {

    Route::get("/weather/{city_id}/{year}/{month}", ApiController::class . "@indexV1")
        ->where([
            "city_id" => "[0-9]+",
            "month" => "[0-9]{1,2}",
            "year" => "[0-9]{4}",
        ]);

    Route::get("/dictionaries", ApiController::class . "@dictionariesV1");

    Route::group(["prefix"=>"resurces"],function (){
        Route::get("/polls", ApiController::class . "@getPolls");
        Route::get("/poll", ApiController::class . "@getPoll");
        Route::get("/pollsId", ApiController::class . "@getPollsId");
    });

});


Route::group(["prefix" => "v2"], function () {

    Route::get("/weather/{city_id}/{year}/{month}", ApiController::class . "@indexV2")
        ->where([
            "city_id" => "[0-9]+",
            "month" => "[0-9]{1,2}",
            "year" => "[0-9]{4}",
        ]);

    Route::get("/dictionaries", ApiController::class . "@dictionariesV2");
});

