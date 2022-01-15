<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\DeviceType;
use App\Enums\ModelType;
use App\Http\Requests\DeviceTypeStoreRequest;
use App\Http\Requests\DeviceTypeUpdateRequest;
use App\Http\Resources\DeviceTypeCollection;
use App\Http\Resources\DeviceTypeResource;
use App\Models\DeviceCoordsHistory;
use Illuminate\Http\Request;

class DeviceTypeController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Добавление тип устройств')->only('store');
        $this->middleware('permission:Просмотр тип устройств')->only('show','index');
        $this->middleware('permission:Удаление тип устройств')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение тип устройств')->only('update', 'restore');
        $this->middleware('permission:Восстановление тип устройств')->only('restore');
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DeviceTypeCollection
     */
    public function index(Request $request)
    {
        $deviceTypes = DeviceType::all();

        return new DeviceTypeCollection($deviceTypes);
    }

    /**
     * @param \App\Http\Requests\DeviceTypeStoreRequest $request
     * @return \App\Http\Resources\DeviceTypeResource
     */
    public function store(DeviceTypeStoreRequest $request)
    {
        $deviceType = DeviceType::create($request->validated());

        $this->setAfter((object)$deviceType);
        $this->saveHistory("Создание", ModelType::DeviceType);

        return new DeviceTypeResource($deviceType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeviceType $deviceType
     * @return \App\Http\Resources\DeviceTypeResource
     */
    public function show(Request $request, DeviceType $deviceType)
    {
        return new DeviceTypeResource($deviceType);
    }

    /**
     * @param \App\Http\Requests\DeviceTypeUpdateRequest $request
     * @param \App\DeviceType $deviceType
     * @return \App\Http\Resources\DeviceTypeResource
     */
    public function update(DeviceTypeUpdateRequest $request, DeviceType $deviceType)
    {
        $this->setBefore((object)DeviceType::find($deviceType->id));

        $deviceType->update($request->validated());

        $this->setAfter((object)$deviceType);
        $this->saveHistory("Редактирование", ModelType::DeviceType);

        return new DeviceTypeResource($deviceType);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeviceType $deviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeviceType $deviceType)
    {
        $keep_array = [1,2,3,4];

        if (in_array($deviceType->id,$keep_array) )
            return response()->noContent();


        $this->setBefore((object)$deviceType);

        $deviceType->delete();

        $this->setAfter((object)$deviceType);
        $this->saveHistory("Удаление", ModelType::DeviceType);

        return response()->noContent();
    }
}
