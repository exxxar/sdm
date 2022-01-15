<?php

use App\DeviceParametersHistory;
use App\Exports\BoundaryScheduleMovableExport;
use App\Imports\DictionaryImport;
use App\Imports\OutputHistoryImport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Classes\DeviceParameterHistoryLogger;
use App\Device;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test', function () {

    echo Carbon::now()->startOfHour();
    echo Carbon::now()->endOfHour();

});


//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/list', function () {
//     ini_set('max_execution_time', '36000');
//     $devices = Device::all();
//     $array = [];

//     foreach ($devices as $key => $device) {
//         $object = (object) [
//             "serial" => $device->serial,
//             "type" => $device->deviceType->title,
//             "passages" => $device->getPassagesByPeriod(Carbon::now()->subDay()->hours(0)->minutes()->seconds(0)->milliseconds(0)->addHours(3), Carbon::now()->hours(0)->minutes(0)->seconds(0)->milliseconds(0)->addHours(3)),
//             "violations" => $device->getViolationsByPeriod(Carbon::now()->subDay()->hours(0)->minutes()->seconds(0)->milliseconds(0)->addHours(3), Carbon::now()->hours(0)->minutes(0)->seconds(0)->milliseconds(0)->addHours(3)),
//             "start" => Carbon::now()->subDay()->hours(0)->minutes(0)->seconds(0)->milliseconds(0)->addHours(3),
//             "end" => Carbon::now()->hours(0)->minutes(0)->seconds(0)->milliseconds(0)->addHours(3)
//         ];

//         array_push($array, $object);
//     }

//     return $array;
// });
// тестовый маршрут для данных с камеры кордон
Route::get("/info/device/{device}", [App\Http\Controllers\ProxiController::class, 'getDeviceInfoWithCheck']);

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/blocking', function () {
    $user = User::find(Auth::user()->id);

    return view("errors.blocking", compact("user"));
})->middleware(['auth'])->name("blocked");

Auth::routes(['register' => false]);

Route::middleware(["check_blocked"])->group(function () {


//Proxi
    Route::post('/devices/info/{device}', [App\Http\Controllers\ProxiController::class, 'getDeviceInfo'])->name('devices.info');
    Route::post('/devices/open', [App\Http\Controllers\ProxiController::class, 'openDevice'])->name('devices.open');
    Route::post('/devices/current-info/{device}', [App\Http\Controllers\ProxiController::class, 'getCurrentDeviceInfo'])->name('devices.current-info');

//Обращения
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/tasks/add', [App\Http\Controllers\HomeController::class, 'tasksAdd'])->name('tasks.add');
    Route::get('/tasks/edit/{task}', [App\Http\Controllers\HomeController::class, 'tasksEdit'])->name('tasks.edit');
    Route::get('/task/reset_all_appeals', [App\Http\Controllers\TaskController::class, 'resetErrors']);
    Route::get('/tasks/{task}', [App\Http\Controllers\HomeController::class, 'tasksShow'])->name('tasks.show');
    Route::get('/tasks/restore/{task}', [App\Http\Controllers\TaskController::class, 'tasksRestore'])->name('tasks.restore');


    Route::get('/history/tasks', [App\Http\Controllers\HomeController::class, 'tasksHistory'])->name('tasks.history');
//Устройства
    Route::get('/devices', [App\Http\Controllers\HomeController::class, 'devices'])->name('devices');

    Route::get('/devices/add', [App\Http\Controllers\HomeController::class, 'devicesAdd'])->name('devices.add');
    Route::get('/devices/{device}', [App\Http\Controllers\HomeController::class, 'devicesShow'])->name('devices.show');
    Route::get('/devices/edit/{device}', [App\Http\Controllers\HomeController::class, 'devicesEdit'])->name('devices.edit');
//Группы устройств
    Route::get('/device-groups', [App\Http\Controllers\HomeController::class, 'deviceGroups'])->name('device.groups');
    Route::get('/device-groups/add', [App\Http\Controllers\HomeController::class, 'deviceGroupsAdd'])->name('device.groups.add');
    Route::get('/device-groups/edit/{deviceGroup}', [App\Http\Controllers\HomeController::class, 'deviceGroupsEdit'])->name('device.groups.edit');
    Route::get('/device-groups/{deviceGroup}', [App\Http\Controllers\HomeController::class, 'deviceGroupsShow'])->name('device.groups.show');
//Рубежи
    Route::get('/boundaries', [App\Http\Controllers\HomeController::class, 'boundaries'])->name('boundaries');
    Route::get('/boundaries/add', [App\Http\Controllers\HomeController::class, 'boundariesAdd'])->name('boundaries.add');
    Route::get('/boundaries/edit/{boundary}', [App\Http\Controllers\HomeController::class, 'boundariesEdit'])->name('boundaries.edit');
    Route::get('/boundaries/schedule', [App\Http\Controllers\HomeController::class, 'boundariesSchedule'])->name('boundaries.schedule');
    Route::get('/boundaries/{boundary}', [App\Http\Controllers\HomeController::class, 'boundariesShow'])->name('boundaries.show');

//Группы рубежей
    Route::get('/boundary-groups', [App\Http\Controllers\HomeController::class, 'boundaryGroups'])->name('boundary.groups');
    Route::get('/boundary-groups/add', [App\Http\Controllers\HomeController::class, 'boundaryGroupsAdd'])->name('boundary.groups.add');
    Route::get('/boundary-groups/edit/{boundaryGroup}', [App\Http\Controllers\HomeController::class, 'boundaryGroupsEdit'])->name('boundary.groups.edit');
//Карта
    Route::get('/map', [App\Http\Controllers\HomeController::class, 'map'])->name('map');
    Route::get('/map/historical/{device}', [App\Http\Controllers\HomeController::class, 'loadHistorical'])->name('map');
//Сводка
    Route::get('/summary', [App\Http\Controllers\HomeController::class, 'summary'])->name('summary');
//История
    Route::get('/operations-history', [App\Http\Controllers\HomeController::class, 'history'])->name('operations-history')->middleware(['permission:Просмотр истории операций']);
//Пользователи
    Route::get('/users', [App\Http\Controllers\HomeController::class, 'users'])->name('users');
    Route::get('/users/add', [App\Http\Controllers\HomeController::class, 'usersAdd'])->name('users.add');
    Route::get('/users/{user}', [App\Http\Controllers\HomeController::class, 'usersShow'])->name('users.show');
    Route::get('/users/edit/{user}', [App\Http\Controllers\HomeController::class, 'usersEdit'])->name('users.edit');
//Справочники
    Route::get('/dictionary-types', [App\Http\Controllers\HomeController::class, 'dictionaryTypes'])->name('dictionary.types');
    Route::get('/dictionary-types/add', [App\Http\Controllers\HomeController::class, 'dictionaryTypesAdd'])->name('dictionary.types.add');
    Route::get('/dictionary-types/edit/{dictionary_type}', [App\Http\Controllers\HomeController::class, 'dictionaryTypesEdit'])->name('dictionary.types.edit');
    Route::get('/dictionaries/add/{dictionary_type}', [App\Http\Controllers\HomeController::class, 'dictionariesAdd'])->name('dictionaries.add');
    Route::get('/dictionaries/edit/{dictionary}', [App\Http\Controllers\HomeController::class, 'dictionariesEdit'])->name('dictionaries.edit');
//Отчеты
    Route::get('/reports', [App\Http\Controllers\HomeController::class, 'reports'])->name('reports');
    Route::get('/reports/add', [App\Http\Controllers\HomeController::class, 'reportsAdd'])->name('reports.add');
    Route::get('/reports/edit/{report}', [App\Http\Controllers\HomeController::class, 'reportsEdit'])->name('reports.edit');
    Route::get('/reports/{report}', [App\Http\Controllers\HomeController::class, 'reportsShow'])->name('reports.show');
    Route::get('/reports/show/automatic', [App\Http\Controllers\HomeController::class, 'reportsAutomatic'])->name('reports.automatic');
    Route::get('/report-templates', [App\Http\Controllers\HomeController::class, 'reportTemplates'])->name('report.templates');
    Route::get('/report-templates/add', [App\Http\Controllers\HomeController::class, 'reportTemplatesAdd'])->name('report.templates.add');
    Route::get('/report-templates/edit/{report_template}', [App\Http\Controllers\HomeController::class, 'reportTemplatesEdit'])->name('report.templates.edit');
    Route::get('/report-templates/{report_template}', [App\Http\Controllers\HomeController::class, 'reportTemplatesShow'])->name('report.templates.show');

    Route::get('/system-info', [App\Http\Controllers\HomeController::class, 'systemInfo'])->name('system.info');

    Route::apiResource('device-type', 'DeviceTypeController');
    Route::apiResource('region', 'RegionController');
    Route::post('boundary/toggle/{boundary}', [App\Http\Controllers\BoundaryController::class, 'toggle'])->name('boundary.toggle');
    Route::post('boundary/toggle-all', [App\Http\Controllers\BoundaryController::class, 'toggleAll'])->name('boundary.toggle.all');
    Route::apiResource('boundary', 'BoundaryController');
    Route::post('device/toggle/{device}', [App\Http\Controllers\DeviceController::class, 'toggle'])->name('device.toggle');
    Route::post('device/toggle-all', [App\Http\Controllers\DeviceController::class, 'toggleAll'])->name('device.toggle.all');
//Route::get('device/restore/{device}', [App\Http\Controllers\DeviceController::class, 'restore'])->name('device.restore');
    Route::post('device/violations/period/{device}', [App\Http\Controllers\DeviceController::class, 'getDeviceViolationsByPeriod'])->name('device.violations.period');
    Route::post('device/passages/period/{device}', [App\Http\Controllers\DeviceController::class, 'getDevicePassagesByPeriod'])->name('device.passages.period');
    Route::apiResource('device', 'DeviceController');
    Route::apiResource('task-status', 'TaskStatusController');
    Route::post('task/getByDeviceId', [App\Http\Controllers\TaskController::class, 'getByDeviceId'])->name('task.getByDeviceId');
    Route::apiResource('task', 'TaskController');
    Route::apiResource('device-group', 'DeviceGroupController');
    Route::apiResource('boundary-group', 'BoundaryGroupController');
    Route::get('/dictionary/restore/{id}', [App\Http\Controllers\DictionaryController::class, 'restore'])->name('restoredictionaries');
    Route::apiResource('dictionary', 'DictionaryController');
    Route::apiResource('dictionary-type', 'DictionaryTypeController');
    Route::post('history/get', [App\Http\Controllers\HistoryController::class, 'getByIdAndType'])->name('history.get');

    Route::apiResource('history', 'HistoryController');
    Route::get('/user/restore/{id}', [App\Http\Controllers\UserController::class, 'restore'])->name('restoredictionaries');

    Route::apiResource('user', 'UserController');

    Route::post("/role/assing/{userId}", [App\Http\Controllers\RoleController::class, 'giveRoleToUser']);
    Route::apiResource('role', 'RoleController');
    Route::post('report/toggle/{report}', [App\Http\Controllers\ReportController::class, 'toggle'])->name('report.toggle');
    Route::post('report/toggle-all', [App\Http\Controllers\ReportController::class, 'toggleAll'])->name('report.toggle.all');
    Route::post('report/sendReportToEmails', [App\Http\Controllers\ReportController::class, 'sendReportToEmails']);
    Route::post('report/sendAllReportsToEmails', [App\Http\Controllers\ReportController::class, 'sendAllReportsToEmails']);
    Route::apiResource('report', 'ReportController');
    Route::apiResource('report-template', 'ReportTemplateController');
    Route::apiResource('device-coords-history', 'DeviceCoordsHistoryController');
    Route::post('/summary/getSummary', [App\Http\Controllers\DeviceParametersHistoryController::class, 'getSummary']);
    Route::post('/summary/downloadSummary', [App\Http\Controllers\DeviceParametersHistoryController::class, 'downloadSummary']);
    Route::post('/summary/getDateRangeForSummaryByPeriod', [App\Http\Controllers\DeviceParametersHistoryController::class, 'getDateRangeForSummaryByPeriod']);
    Route::apiResource('device-parameters-history', 'DeviceParametersHistoryController');


    Route::get('/boundary-schedule/movable/{monthIndex?}', [\App\Http\Controllers\BoundaryScheduleController::class, "getBoundaryScheduleMovable"]);
    Route::get('/boundary-schedule/static', [\App\Http\Controllers\BoundaryScheduleController::class, "getBoundaryScheduleStatic"]);


    Route::post('/boundary-schedule/filtered/movable', [\App\Http\Controllers\BoundaryScheduleController::class, "getFilteredMovabaleSchedule"]);
    Route::post('/boundary-schedule/filtered/static', [\App\Http\Controllers\BoundaryScheduleController::class, "getFilteredStaticSchedule"]);


    Route::apiResource('boundary-schedule', 'BoundaryScheduleController');

    Route::post('/download-boundary-schedule-movable', [\App\Http\Controllers\BoundaryScheduleController::class, "scheduleMovableDownload"]);
    Route::post('/download-boundary-schedule-static', [\App\Http\Controllers\BoundaryScheduleController::class, "scheduleStaticDownload"]);

    Route::post('/send-dictionary-file', [\App\Http\Controllers\DictionaryController::class, "dictionaryUpload"]);

    Route::post('/send-devices-file', [\App\Http\Controllers\DeviceController::class, "deviceUpload"]);
    Route::post('/send-device-groups-file', [\App\Http\Controllers\DeviceGroupController::class, "devicGroupUpload"]);
    Route::post('/send-boundary-file', [\App\Http\Controllers\BoundaryController::class, "boundaryUpload"]);
    Route::post('/send-boundary-groups-file', [\App\Http\Controllers\BoundaryGroupController::class, "boundaryGroupUpload"]);

    Route::get('/device-groups/restore/{id}', [App\Http\Controllers\DeviceGroupController::class, 'restore'])->name('restore.devicegroups');
    Route::get('/boundary-groups/restore/{id}', [App\Http\Controllers\BoundaryGroupController::class, 'restore'])->name('restore.boundarygroups');
    Route::get('/boundaries/restore/{id}', [App\Http\Controllers\BoundaryController::class, 'restore'])->name('resotre.boundaries');
    Route::get('/devices/restore/{id}', [App\Http\Controllers\DeviceController::class, 'restore'])->name('resotre.devices');

    Route::get('/templates/{template_type}', [App\Http\Controllers\HomeController::class, 'getTemplate'])->name('templates.get');


    Route::post('/task/update_notes/{appealId}', [\App\Http\Controllers\TaskController::class, "updateNotes"]);


    Route::apiResource('location', 'LocationController');

    Route::post('/device/assign', [App\Http\Controllers\DeviceController::class, 'assignLocation'])->name('assing');
    Route::post('/device/detach', [App\Http\Controllers\DeviceController::class, 'detachLocation'])->name('detach');


    Route::get("/import_old_data", function () {

        ini_set('max_execution_time', 20000);
        ini_set('memory_limit', '1256M');
        Excel::import(new OutputHistoryImport, storage_path('app/public/templates/') . 'output.xlsx');
        ini_set('max_execution_time', 20);
        return "";
    });
});
