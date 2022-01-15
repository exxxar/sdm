<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\DictionaryType;
use App\Enums\ModelType;
use App\History;
use App\Http\Requests\HistoryStoreRequest;
use App\Http\Requests\HistoryUpdateRequest;
use App\Http\Resources\HistoryCollection;
use App\Http\Resources\HistoryResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр справочников')->only('index','show');
        $this->middleware('permission:Добавление справочников')->only('store');
        $this->middleware('permission:Удаление справочников')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение справочников')->only('update');
        $this->middleware('permission:Восстановление справочников')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\HistoryCollection
     */
    public function index(Request $request)
    {
        $filters = (object) [
            'operation_type' => $request->operation_type,
            'object_id' => $request->object_id,
            'object_type_id' => $request->object_type_id,
            'selected_user' => $request->selected_user,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];

        $histories = History::withFilters(
            $filters
        )->paginate(30);

        return new HistoryCollection($histories);
    }

    public function getByIdAndType(Request $request)
    {
        $validator = $request->validate([
            'id' => 'required',
            'type' => 'required',
        ]);

        $histories = History::with(['user'])
            ->where('object_id', $request->id)
            ->where('type', $request->type)->get();

        return new HistoryCollection($histories);
    }

    /**
     * @param \App\Http\Requests\HistoryStoreRequest $request
     * @return \App\Http\Resources\HistoryResource
     */
    public function store(HistoryStoreRequest $request)
    {
        $history = History::create($request->validated());

        $this->setAfter((object)$history);
        $this->saveHistory("Создание", ModelType::History);

        return new HistoryResource($history);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\History $history
     * @return \App\Http\Resources\HistoryResource
     */
    public function show(Request $request, History $history)
    {
        return new HistoryResource($history);
    }

    /**
     * @param \App\Http\Requests\HistoryUpdateRequest $request
     * @param \App\History $history
     * @return \App\Http\Resources\HistoryResource
     */
    public function update(HistoryUpdateRequest $request, History $history)
    {
        $this->setBefore((object)History::find($history->id));

        $history->update($request->validated());

        $this->setAfter((object)$history);
        $this->saveHistory("Редактирование", ModelType::History);

        return new HistoryResource($history);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\History $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, History $history)
    {
        $this->setBefore((object)$history);

        $history->delete();

        $this->setAfter((object)$history);
        $this->saveHistory("Удаление", ModelType::History);

        return response()->noContent();
    }
}
