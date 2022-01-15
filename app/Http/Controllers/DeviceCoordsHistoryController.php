<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\History;
use App\Models\Report;
use App\Models\ReportTemplate;
use Carbon\Traits\Options;
use Illuminate\Http\Request;
use App\Models\DeviceCoordsHistory;
use App\Http\Requests\DeviceCoordsHistoryStoreRequest;
use App\Http\Requests\DeviceCoordsHistoryUpdateRequest;
use App\Http\Resources\DeviceCoordsHistoryResource;
use App\Http\Resources\DeviceCoordsHistoryCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeviceCoordsHistoryController extends Controller
{
    use OperationHistory;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $device_coords_histories = DeviceCoordsHistory::all();

        return new DeviceCoordsHistoryCollection($device_coords_histories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param \App\Http\Requests\DeviceCoordsHistoryStoreRequest $request
     * @return \App\Http\Resources\DeviceCoordsHistoryResource
     */
    public function store(DeviceCoordsHistoryStoreRequest $request)
    {
        $device_coords_history = DeviceCoordsHistory::create($request->validated());

        $this->setAfter((object)$device_coords_history);
        $this->saveHistory("Добавление координат", ModelType::DeviceCoordsHistory);

        return new DeviceCoordsHistoryResource($device_coords_history);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeviceCoordsHistory $device_coords_history
     * @return \App\Http\Resources\DeviceCoordsHistoryResource
     */
    public function show(Request $request, DeviceCoordsHistory $device_coords_history)
    {
        return new DeviceCoordsHistoryResource($device_coords_history);
    }

    /**
     * @param \App\Http\Requests\DeviceCoordsHistoryUpdateRequest $request
     * @param \App\Models\DeviceCoordsHistory $device_coords_history
     * @return \App\Http\Resources\DeviceCoordsHistoryResource
     */
    public function update(DeviceCoordsHistoryUpdateRequest $request, DeviceCoordsHistory $device_coords_history)
    {
        $this->setBefore((object)DeviceCoordsHistory::find($device_coords_history->id));
        $device_coords_history->update($request->validated());

        $this->setAfter((object)$device_coords_history);
        $this->saveHistory("Редактирование координат", ModelType::DeviceCoordsHistory);

        return new DeviceCoordsHistoryResource($device_coords_history);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\DeviceCoordsHistory $device_coords_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeviceCoordsHistory $device_coords_history)
    {
        $this->setBefore((object)$device_coords_history);

        $device_coords_history->delete();

        $this->setAfter((object)$device_coords_history);
        $this->saveHistory("Удаление координат", ModelType::DeviceCoordsHistory);

        return response()->noContent();
    }
}
