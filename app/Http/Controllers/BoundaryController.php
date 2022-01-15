<?php

namespace App\Http\Controllers;

use App\Boundary;
use App\BoundaryGroup;
use App\BoundarySchedule;
use App\Classes\OperationHistory;
use App\Device;
use App\Dictionary;
use App\Enums\ModelType;
use App\History;
use App\Http\Requests\BoundaryStoreRequest;
use App\Http\Requests\BoundaryUpdateRequest;
use App\Http\Resources\BoundaryCollection;
use App\Http\Resources\BoundaryResource;
use App\Imports\BoundaryGroupImport;
use App\Imports\BoundaryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BoundaryController extends Controller
{
    use OperationHistory;


    public function __construct()
    {
        $this->middleware('permission:Просмотр рубежа')->only('index','show');
        $this->middleware('permission:Добавление рубежа')->only('store');
        $this->middleware('permission:Удаление рубежа')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение рубежа')->only('update');
        $this->middleware('permission:Восстановление рубежа')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\BoundaryCollection
     */
    public function index(Request $request)
    {
        $boundaries = Boundary::with(["boundary_group", "devices"])->withTrashed()->orderBy('deleted_at', 'desc')->get();

        return new BoundaryCollection($boundaries);
    }

    /**
     * @param \App\Http\Requests\BoundaryStoreRequest $request
     * @return \App\Http\Resources\BoundaryResource
     */
    public function store(BoundaryStoreRequest $request)
    {
        $boundary = Boundary::create($request->validated());

        $this->setAfter((object)$boundary);
        $this->saveHistory("Создание", ModelType::Boundary);

        foreach ($request->devices as $device) {
            $device = Device::find($device['code']);
            if ($device) {

                $this->setBefore((object)$device);

                $device->device_boundary_id = $boundary->id;
                $device->save();

                $this->setAfter((object)$device);
                $this->saveHistory("Связка рубежа и устройства", ModelType::Device);


            }
        }

        foreach ($request->violations as $violation) {
            $violation = Dictionary::find($violation['code']);
            if ($violation) {
                $boundary->dictionaries()->attach($violation->id);
            }
        }

        return new BoundaryResource($boundary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Boundary $boundary
     * @return \App\Http\Resources\BoundaryResource
     */
    public function show(Request $request, Boundary $boundary)
    {
        return new BoundaryResource($boundary);
    }

    /**
     * @param \App\Http\Requests\BoundaryUpdateRequest $request
     * @param \App\Boundary $boundary
     * @return \App\Http\Resources\BoundaryResource
     */
    public function update(BoundaryUpdateRequest $request, Boundary $boundary)
    {

        $boundary->update($request->validated());

        $bs = BoundarySchedule::where("boundary_id", $boundary->id)->get();

        foreach ($bs as $boundary_item) {
            $this->setBefore((object)$boundary_item);

            $boundary_item->type = $boundary->mobile || $boundary->movable;
            $boundary_item->save();

            $this->setAfter((object)$boundary_item);
            $this->saveHistory("Смена типа рубежа", ModelType::Boundary);
        }

        $this->setAfter((object)$boundary);
        $this->saveHistory("Редактирование", ModelType::Boundary);


        foreach ($boundary->devices as $device) {

            $this->setBefore((object)$device);

            $device->device_boundary_id = null;
            $device->save();

            $this->setAfter((object)$device);
            $this->saveHistory("Обновление рубежа устройства", ModelType::Device);
        }

        foreach ($request->devices as $device) {
            $device = Device::find($device['code']);
            if ($device) {
                $this->setBefore((object)$device);

                $device->device_boundary_id = $boundary->id;
                $device->save();

                $this->setAfter((object)$device);
                $this->saveHistory("Обновление рубежа устройства", ModelType::Device);
            }
        }

        $boundary->dictionaries()->sync([]);

        foreach ($request->violations as $violation) {
            $violation = Dictionary::find($violation['code']);
            if ($violation) {
                $boundary->dictionaries()->attach($violation->id);
            }
        }

        return new BoundaryResource($boundary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Boundary $boundary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Boundary $boundary)
    {
        foreach ($boundary->devices as $device) {
            $device->device_boundary_id = null;
            $device->save();
        }

        $bs = BoundarySchedule::where("boundary_id", $boundary->id)->get();

        foreach ($bs as $boundary_item) {
            $this->setAfter((object)$boundary_item);

            $boundary_item->delete();

            $this->setBefore((object)$boundary_item);
            $this->saveHistory("Удаление из расписания", ModelType::BoundarySchedule);
        }


        $this->setAfter((object)$boundary);
        $this->saveHistory("Удаление", ModelType::Boundary);

        $boundary->dictionaries()->sync([]);

        $boundary->delete();

        return response()->noContent();
    }

    public function toggle(Request $request, Boundary $boundary)
    {
        $this->setBefore((object)$boundary);

        $boundary->is_active = $request->is_active;
        $boundary->save();

        $this->setAfter((object)$boundary);
        $this->saveHistory("Переключение статуса", ModelType::Boundary);

        return response()->noContent();
    }

    public function toggleAll(Request $request)
    {
        $boundaries = Boundary::all();

        foreach ($boundaries as $boundary) {

            $this->setBefore((object)$boundary);

            $boundary->is_active = $request->is_active;
            $boundary->save();

            $this->setAfter((object)$boundary);
            $this->saveHistory("Переключение статуса", ModelType::Boundary);

        }

        return response()->noContent();
    }

    public function boundaryGroupUpload(Request $request)
    {
        $file = $request->file('file');

        $file->getClientOriginalName();

        $file->getClientOriginalExtension();

        $file->getRealPath();

        $file->getSize();

        $file->getMimeType();

        $destinationPath = storage_path('app/public');
        $file->move($destinationPath, $file->getClientOriginalName());


        Excel::import(new BoundaryImport, storage_path('app/public/') . $file->getClientOriginalName());

        return response()->noContent();
    }

    public function restore(Request $request, $id)
    {
        $boundary = Boundary::withTrashed()->find($id);

        $this->setAfter((object)$boundary);

        $boundary->restore();

        BoundarySchedule::withTrashed()->where("boundary_id", $id)->restore();

        $this->setAfter((object)$boundary);
        $this->saveHistory("Восстановление", ModelType::Boundary);

        return response()->noContent();
    }
}
