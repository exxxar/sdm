<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Device;
use App\DeviceGroup;
use App\Enums\ModelType;
use App\History;
use App\Http\Requests\DeviceGroupStoreRequest;
use App\Http\Requests\DeviceGroupUpdateRequest;
use App\Http\Resources\DeviceGroupCollection;
use App\Http\Resources\DeviceGroupResource;
use App\Http\Resources\DeviceGroupResourceWithDevices;
use App\Imports\DeviceGroupImport;
use App\Imports\DictionaryImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DeviceGroupController extends Controller
{
    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр групп устройств')->only('show','index');
        $this->middleware('permission:Добавление групп устройств')->only('store');
        $this->middleware('permission:Удаление групп устройств')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение групп устройств')->only('update', 'restore');
        $this->middleware('permission:Восстановление групп устройств')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DeviceGroupCollection
     */
    public function index(Request $request)
    {
        $deviceGroups = DeviceGroup::withTrashed()->get();

        return new DeviceGroupCollection($deviceGroups);
    }

    /**
     * @param \App\Http\Requests\DeviceGroupStoreRequest $request
     * @return \App\Http\Resources\DeviceGroupResource
     */
    public function store(DeviceGroupStoreRequest $request)
    {
        $deviceGroup = DeviceGroup::create($request->validated());

        foreach ($request->devices as $device) {
            $device = Device::find($device['id']);
            if ($device) {
                $this->setBefore((object)$deviceGroup);

                $device->device_group_id = $deviceGroup->id;
                $device->save();

                $this->setAfter((object)$device);
                $this->saveHistory("Добавление устройства в группу", ModelType::Device);
            }
        }

        $this->setAfter((object)$deviceGroup);
        $this->saveHistory("Создание", ModelType::DeviceGroup);

        return new DeviceGroupResource($deviceGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeviceGroup $deviceGroup
     * @return \App\Http\Resources\DeviceGroupResource
     */
    public function show(Request $request, DeviceGroup $deviceGroup)
    {
        return new DeviceGroupResourceWithDevices($deviceGroup);
    }

    /**
     * @param \App\Http\Requests\DeviceGroupUpdateRequest $request
     * @param \App\DeviceGroup $deviceGroup
     * @return \App\Http\Resources\DeviceGroupResource
     */
    public function update(DeviceGroupUpdateRequest $request, DeviceGroup $deviceGroup)
    {
        foreach ($deviceGroup->devices as $device) {
            $this->setBefore((object)$device);

            $device->device_group_id = null;
            $device->save();

            $this->setAfter((object)$device);
            $this->saveHistory("Сброс группы устройств", ModelType::Device);
        }


        foreach ($request->devices as $device) {
            $device = Device::find($device['id']);
            if ($device) {
                $this->setBefore((object)$device);

                $device->device_group_id = $deviceGroup->id;
                $device->save();

                $this->setAfter((object)$device);
                $this->saveHistory("Присвоение группы устройств", ModelType::Device);
            }
        }

        $this->setBefore((object)$deviceGroup);

        $deviceGroup->update($request->validated());

        $this->setAfter((object)$deviceGroup);
        $this->saveHistory("Редактирование", ModelType::DeviceGroup);


        return new DeviceGroupResource($deviceGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeviceGroup $deviceGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeviceGroup $deviceGroup)
    {
        foreach ($deviceGroup->devices as $device) {

            $this->setBefore((object)$device);

            $device->device_group_id = null;
            $device->save();

            $this->setAfter((object)$device);
            $this->saveHistory("Сброс группы устройств", ModelType::Device);
        }

        $this->setBefore((object)$deviceGroup);

        $deviceGroup->delete();

        $this->setAfter((object)$deviceGroup);
        $this->saveHistory("Редактирование", ModelType::DeviceGroup);

        return response()->noContent();
    }

    public function devicGroupUpload(Request $request)
    {
        $file = $request->file('file');

        $file->getClientOriginalName();

        $file->getClientOriginalExtension();

        $file->getRealPath();

        $file->getSize();

        $file->getMimeType();

        $destinationPath = storage_path('app/public');
        $file->move($destinationPath, $file->getClientOriginalName());

        Excel::import(new DeviceGroupImport, storage_path('app/public/') . $file->getClientOriginalName());



        return response()->noContent();
    }

    public function restore(Request $request, $id)
    {
        $deviceGroup = DeviceGroup::withTrashed()->find($id);
        $this->setBefore((object)$deviceGroup);

        $deviceGroup->restore();

        $this->setAfter((object)$deviceGroup);
        $this->saveHistory("Восстановление", ModelType::DeviceGroup);

        return response()->noContent();
    }
}
