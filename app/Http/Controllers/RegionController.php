<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\Http\Requests\RegionStoreRequest;
use App\Http\Requests\RegionUpdateRequest;
use App\Http\Resources\RegionCollection;
use App\Http\Resources\RegionResource;
use App\Location;
use App\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Добавление регионов')->only('store');
        $this->middleware('permission:Просмотр регионов')->only('show','index');
        $this->middleware('permission:Удаление регионов')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение регионов')->only('update');
        $this->middleware('permission:Восстановление регионов')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\RegionCollection
     */
    public function index(Request $request)
    {
        $regions = Region::all();

        return new RegionCollection($regions);
    }

    /**
     * @param \App\Http\Requests\RegionStoreRequest $request
     * @return \App\Http\Resources\RegionResource
     */
    public function store(RegionStoreRequest $request)
    {
        $region = Region::create($request->validated());

        $this->setAfter((object)$region);
        $this->saveHistory("Создание", ModelType::Region);

        return new RegionResource($region);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Region $region
     * @return \App\Http\Resources\RegionResource
     */
    public function show(Request $request, Region $region)
    {
        return new RegionResource($region);
    }

    /**
     * @param \App\Http\Requests\RegionUpdateRequest $request
     * @param \App\Region $region
     * @return \App\Http\Resources\RegionResource
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        $this->setBefore((object)Region::find($region->id));

        $region->update($request->validated());

        $this->setAfter((object)$region);
        $this->saveHistory("Редактирование", ModelType::Region);

        return new RegionResource($region);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Region $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Region $region)
    {
        $this->setBefore((object)$region);

        $region->delete();

        $this->setAfter((object)$region);
        $this->saveHistory("Удаление", ModelType::Region);

        return response()->noContent();
    }
}
