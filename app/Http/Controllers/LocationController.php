<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\History;
use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    use OperationHistory;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\LocationCollection
     */
    public function index(Request $request)
    {
        $locations = Location::all();

        return new LocationCollection($locations);
    }

    /**
     * @param \App\Http\Requests\LocationStoreRequest $request
     * @return \App\Http\Resources\LocationResource
     */
    public function store(LocationStoreRequest $request)
    {
        $location = Location::create($request->validated());

        $this->setAfter((object)$location);
        $this->saveHistory("Создание", ModelType::Location);

        return new LocationResource($location);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Location $location
     * @return \App\Http\Resources\LocationResource
     */
    public function show(Request $request, Location $location)
    {
        return new LocationResource($location);
    }

    /**
     * @param \App\Http\Requests\LocationUpdateRequest $request
     * @param \App\Location $location
     * @return \App\Http\Resources\LocationResource
     */
    public function update(LocationUpdateRequest $request, Location $location)
    {

        $this->setBefore((object)Location::find($location->id));

        $location->update($request->validated());

        $this->setAfter((object)$location);
        $this->saveHistory("Редактирование", ModelType::Location);

        return new LocationResource($location);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Location $location)
    {
        $this->setBefore((object)$location);

        $location->delete();

        $this->setAfter((object)$location);
        $this->saveHistory("Удаление", ModelType::Location);

        return response()->noContent();
    }
}
