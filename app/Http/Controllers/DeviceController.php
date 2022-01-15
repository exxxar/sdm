<?php

namespace App\Http\Controllers;

use App\BoundaryGroup;
use App\Classes\OperationHistory;
use App\Device;
use App\Enums\ModelType;
use App\History;
use App\Http\Requests\DeviceStoreRequest;
use App\Http\Requests\DeviceUpdateRequest;
use App\Http\Resources\DeviceCollection;
use App\Http\Resources\DeviceResource;
use App\Imports\BoundaryImport;
use App\Imports\DeviceImport;
use App\Jobs\DeviceCacheJob;
use App\Models\DeviceCoordsHistory;
use App\Models\ReportTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DeviceController extends Controller
{
    use OperationHistory;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:Просмотр устройств')->only('index','show');
        $this->middleware('permission:Добавление устройств')->only('store');
        $this->middleware('permission:Удаление устройств')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение устройств')->only('update');
        $this->middleware('permission:Восстановление устройств')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DeviceCollection
     */
    public function index(Request $request)
    {
        $filters = (object) [
            'deleted' => $request->deleted,
            'serial' => $request->serial,
            'boundary' => $request->boundary,
            'group' => $request->group,
            'type' => $request->type,
            'device_class' => $request->device_class
        ];

        $devices = Device::withFilters(
            $filters
        )->orderByRaw('-deleted_at DESC')->paginate(50);

        return new DeviceCollection($devices);
    }

    /**
     * @param \App\Http\Requests\DeviceStoreRequest $request
     * @return \App\Http\Resources\DeviceResource
     */
    public function store(DeviceStoreRequest $request)
    {
        $device = Device::create($request->validated());


        $this->setAfter((object)$device);
        $this->saveHistory("Создание", ModelType::Device);


        if ($device->lat != null && $device->lon != null) {
            $dch = DeviceCoordsHistory::create([
                'device_id' => $device->id,
                'lat' => $device->lat,
                'lon' => $device->lon
            ]);

            $this->setAfter((object)$dch);
            $this->saveHistory("Создание", ModelType::DeviceCoordsHistory);
        }

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return new DeviceResource($device);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Device $device
     * @return \App\Http\Resources\DeviceResource
     */
    public function show(Request $request, Device $device)
    {
        return new DeviceResource($device);
    }

    /**
     * @param \App\Http\Requests\DeviceUpdateRequest $request
     * @param \App\Device $device
     * @return \App\Http\Resources\DeviceResource
     */
    public function update(DeviceUpdateRequest $request, Device $device)
    {

        if ($request->lat != $device->lat || $request->lon != $device->lon) {
            $dch = DeviceCoordsHistory::create([
                'device_id' => $device->id,
                'lat' => $request->lat,
                'lon' => $request->lon
            ]);

            $this->setAfter((object)$dch);
            $this->saveHistory("Создание", ModelType::DeviceCoordsHistory);
        }

        $this->setBefore((object)Device::find($device->id));

        $device->update($request->validated());

        $this->setAfter((object)$device);
        $this->saveHistory("Редактирование", ModelType::Device);

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return new DeviceResource($device);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Device $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Device $device)
    {
        $this->setBefore((object)$device);

        $device->appeals()->forceDelete();

        $device->device_boundary_id = null;
        $device->save();

        //$deleted_device_coords_history = DeviceCoordsHistory::where('device_id', $device->id)->delete();
        $device->delete();

        $this->setAfter((object)$device);
        $this->saveHistory("Удаление", ModelType::Device);

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return response()->noContent();
    }

    public function toggle(Request $request, Device $device)
    {
        $this->setBefore((object)$device);

        $device->is_active = $request->is_active;
        $device->save();

        $this->setAfter((object)$device);
        $this->saveHistory("Смена типа активности", ModelType::Device);

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return response()->noContent();
    }

    public function toggleAll(Request $request)
    {
        $devices = Device::all();

        foreach ($devices as $device) {
            $this->setBefore((object)$device);

            $device->is_active = $request->is_active;
            $device->save();

            $this->setAfter((object)$device);
            $this->saveHistory("Смена типа активности", ModelType::Device);
        }

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return response()->noContent();
    }

    public function restore(Request $request, $id)
    {
        $device = Device::withTrashed()->find($id);
        $this->setBefore((object)$device);

        $device->restore();

        $this->setAfter((object)$device);
        $this->saveHistory("Восстановление", ModelType::Device);

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return response()->noContent();
    }

    public function deviceUpload(Request $request)
    {
        $file = $request->file('file');

        $file->getClientOriginalName();

        $file->getClientOriginalExtension();

        $file->getRealPath();

        $file->getSize();

        $file->getMimeType();

        $destinationPath = storage_path('app/public');
        $file->move($destinationPath, $file->getClientOriginalName());

        Excel::import(new DeviceImport, storage_path('app/public/') . $file->getClientOriginalName());

        DeviceCacheJob::dispatch()->delay(now()->addSeconds(1));

        return response()->noContent();
    }

    public function assignLocation(Request $request)
    {
        $request->validate([
            "location_id" => "required",
            "device_id" => "required"
        ]);

        $device = Device::where("id", $request->get("device_id"))->first();
        $this->setBefore((object)$device);

        $device->location_id = $request->get("location_id") ?? null;
        $device->save();

        $this->setAfter((object)$device);
        $this->saveHistory("Связь с локацией", ModelType::Device);

        return response()->json($device);
    }

    public function detachLocation(Request $request)
    {
        $request->validate([
            "location_id" => "required",
            "device_id" => "required"
        ]);

        $device = Device::find($request->device_id);

        $this->setBefore((object)$device);

        $device->location_id = null;
        $device->save();

        $this->setAfter((object)$device);
        $this->saveHistory("Удаление связи с локацией", ModelType::Device);

        return response()->noContent();
    }

    public function getDeviceViolationsByPeriod(Request $request, Device $device)
    {
        return $device->getViolationsByPeriod($request->startTime, $request->endTime);
    }

    public function getDevicePassagesByPeriod(Request $request, Device $device)
    {
        return $device->getPassagesByPeriod($request->startTime, $request->endTime);
    }
}
