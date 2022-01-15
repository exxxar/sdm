<?php

namespace App\Http\Controllers;

use App\Boundary;
use App\BoundaryGroup;
use App\Classes\OperationHistory;
use App\DeviceGroup;
use App\Enums\ModelType;
use App\History;
use App\Http\Requests\BoundaryGroupStoreRequest;
use App\Http\Requests\BoundaryGroupUpdateRequest;
use App\Http\Resources\BoundaryGroupCollection;
use App\Http\Resources\BoundaryGroupResource;
use App\Imports\BoundaryGroupImport;
use App\Imports\DeviceGroupImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class BoundaryGroupController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр группы рубежей')->only('index','show');
        $this->middleware('permission:Добавление группы рубежей')->only('store');
        $this->middleware('permission:Удаление группы рубежей')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение группы рубежей')->only('update');
        $this->middleware('permission:Восстановление группы рубежей')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\BoundaryGroupCollection
     */
    public function index(Request $request)
    {
        $boundaryGroups = BoundaryGroup::withTrashed()->get();

        return new BoundaryGroupCollection($boundaryGroups);
    }

    /**
     * @param \App\Http\Requests\BoundaryGroupStoreRequest $request
     * @return \App\Http\Resources\BoundaryGroupResource
     */
    public function store(BoundaryGroupStoreRequest $request)
    {
        $boundaryGroup = BoundaryGroup::create($request->validated());

        $this->setAfter((object)$boundaryGroup);
        $this->saveHistory("Создание", ModelType::BoundaryGroup);

        foreach ($request->boundaries as $boundary)
        {
            $boundary = Boundary::find($boundary['id']);
            if ($boundary) {
                $this->setBefore((object)$boundary);

                $boundary->boundary_group_id = $boundaryGroup->id;
                $boundary->save();

                $this->setAfter((object)$boundary);
                $this->saveHistory("Добавление в группу", ModelType::Boundary);
            }
        }

        return new BoundaryGroupResource($boundaryGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\BoundaryGroup $boundaryGroup
     * @return \App\Http\Resources\BoundaryGroupResource
     */
    public function show(Request $request, BoundaryGroup $boundaryGroup)
    {
        return new BoundaryGroupResource($boundaryGroup);
    }

    /**
     * @param \App\Http\Requests\BoundaryGroupUpdateRequest $request
     * @param \App\BoundaryGroup $boundaryGroup
     * @return \App\Http\Resources\BoundaryGroupResource
     */
    public function update(BoundaryGroupUpdateRequest $request, BoundaryGroup $boundaryGroup)
    {
        $boundaryGroup->update($request->validated());

        foreach ($boundaryGroup->boundaries as $boundary)
        {
            $this->setBefore((object)$boundary);

            $boundary->boundary_group_id = null;
            $boundary->save();

            $this->setAfter((object)$boundary);
            $this->saveHistory("Обновление группы (сброс)", ModelType::Boundary);
        }

        foreach ($request->boundaries as $boundary)
        {
            $boundary = Boundary::find($boundary['id']);
            if ($boundary) {
                $this->setBefore((object)$boundary);

                $boundary->boundary_group_id = $boundaryGroup->id;
                $boundary->save();

                $this->setAfter((object)$boundary);
                $this->saveHistory("Обновление группы", ModelType::Boundary);
            }
        }

        return new BoundaryGroupResource($boundaryGroup);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\BoundaryGroup $boundaryGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BoundaryGroup $boundaryGroup)
    {
        foreach ($boundaryGroup->boundaries as $boundary)
        {
            $this->setBefore((object)$boundary);

            $boundary->boundary_group_id = null;
            $boundary->save();


            $this->setAfter((object)$boundary);
            $this->saveHistory("Обновление группы (сброс)", ModelType::Boundary);
        }

        $boundaryGroup->delete();

        return response()->noContent();
    }

    public function restore(Request $request, $id)
    {

        $boundaryGroup = BoundaryGroup::withTrashed()->find($id);

        $this->setBefore((object)$boundaryGroup);

        $boundaryGroup->restore();

        $this->setAfter((object)$boundaryGroup);
        $this->saveHistory("Восстановление", ModelType::BoundaryGroup);

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

        Excel::import(new BoundaryGroupImport, storage_path('app/public/') . $file->getClientOriginalName());



        return response()->noContent();
    }
}
