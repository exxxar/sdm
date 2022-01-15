<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\Http\Requests\TaskStatusStoreRequest;
use App\Http\Requests\TaskStatusUpdateRequest;
use App\Http\Resources\TaskStatusCollection;
use App\Http\Resources\TaskStatusResource;
use App\Task;
use App\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{

    use OperationHistory;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\TaskStatusCollection
     */
    public function index(Request $request)
    {
        $taskStatuses = TaskStatus::all();

        return new TaskStatusCollection($taskStatuses);
    }

    /**
     * @param \App\Http\Requests\TaskStatusStoreRequest $request
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function store(TaskStatusStoreRequest $request)
    {
        $taskStatus = TaskStatus::create($request->validated());

        $this->setAfter((object)$taskStatus);
        $this->saveHistory("Создание", ModelType::TaskStatus);

        return new TaskStatusResource($taskStatus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\TaskStatus $taskStatus
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function show(Request $request, TaskStatus $taskStatus)
    {
        return new TaskStatusResource($taskStatus);
    }

    /**
     * @param \App\Http\Requests\TaskStatusUpdateRequest $request
     * @param \App\TaskStatus $taskStatus
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function update(TaskStatusUpdateRequest $request, TaskStatus $taskStatus)
    {
        $this->setBefore((object)TaskStatus::find($taskStatus->id));

        $taskStatus->update($request->validated());

        $this->setAfter((object)$taskStatus);
        $this->saveHistory("Редактирование", ModelType::TaskStatus);

        return new TaskStatusResource($taskStatus);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\TaskStatus $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TaskStatus $taskStatus)
    {
        $this->setBefore((object)$taskStatus);

        $taskStatus->delete();

        $this->setAfter((object)$taskStatus);
        $this->saveHistory("Удаление", ModelType::TaskStatus);


        return response()->noContent();
    }
}
