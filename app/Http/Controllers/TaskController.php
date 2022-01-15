<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\Events\AddHistoryEvent;
use App\Events\UserNotifyEvent;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Report;
use App\Models\User;
use App\Task;
use App\History;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр обращений')->only('index', 'show');
        $this->middleware('permission:Изменение обращений')->only('edit', 'update','resetErrors');
        $this->middleware('permission:Удаление обращений')->only('destroy', 'forceDelete');
        $this->middleware('permission:Восстановление обращений')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\TaskCollection
     */
    public function index(Request $request)
    {
        $filters = (object)[
            'deleted' => $request->deleted,
            'actual' => $request->actual,
            'ready' => $request->ready,
            'boundary' => $request->boundary,
            'malfunction' => $request->malfunction,
            'direction' => $request->direction,
            'device_id' => $request->device_id,
            'boundary_id' => $request->boundary_id,
            'task_id' => $request->task_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];

        $tasks = Task::withFilters(
            $filters
        )->paginate(20);

        return new TaskCollection($tasks);
    }

    /**
     * @param \App\Http\Requests\TaskStoreRequest $request
     * @return \App\Http\Resources\TaskResource
     */
    public function store(TaskStoreRequest $request)
    {

        $task = Task::create($request->validated());

        $task->report_id = $request->report_id;
        $task->save();

        $this->setAfter((object)$task);
        $this->saveHistory("Создание", ModelType::Task);
        if ($request->notify) {
            $user = User::find($request->responsible_id);
            event(new UserNotifyEvent("Для вас создана задача", $user->email));
        }


        return new TaskResource($task);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \App\Http\Resources\TaskResource
     */
    public function show(Request $request, Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * @param \App\Http\Requests\TaskUpdateRequest $request
     * @param \App\Task $task
     * @return \App\Http\Resources\TaskResource
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $this->setBefore((object)Task::find($task->id));

        $task->update($request->validated());

        $task->report_id = $request->report_id;
        $task->save();


        $this->setAfter((object)$task);
        $this->saveHistory("Редактирование", ModelType::Task);
        if ($request->notify) {
            $user = User::find($request->responsible_id);
            event(new UserNotifyEvent("Для вас отредактирована задача", $user->email));
        }

        return new TaskResource($task);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task)
    {

        $user = User::find($task->responsible_id);
        event(new UserNotifyEvent("Ваша задача удалена", $user->email));

        $this->setBefore((object)$task);
        $task->delete();
        $this->setAfter((object)$task);
        $this->saveHistory("Редактирование", ModelType::Task);

        return response()->noContent();
    }

    public function resetErrors()
    {

        $tasks = Task::whereNotIn("status", ["Готово"])->get();

        foreach ($tasks as $task) {

            $this->setBefore((object)$task);

            $task->status = "Готово";
            $task->save();
            $user = User::find($task->responsible_id);
            if (!is_null($user))
                event(new UserNotifyEvent("Для вашей задачи сменился статус", $user->email));
            $this->setAfter((object)$task);
            $this->saveHistory("Смена статуса", ModelType::Task);

        }

        return response()->noContent();
    }

    public function getByDeviceId(Request $request)
    {
        $validator = $request->validate([
            'id' => 'required',
        ]);

        $tasks = Task::where('device_id', $request->id)->get();

        return new TaskCollection($tasks);
    }

    public function updateNotes(Request $request, $id)
    {
        $task = Task::find($id);

        $this->setBefore((object)$task);

        $task->notes = $request->notes;
        $task->save();
        $this->setAfter((object)$task);
        $this->saveHistory("Обновлены заметки", ModelType::Task);

        return response()->noContent();
    }

    public function tasksRestore($taskId){
        $task = Task::withTrashed()->where("id",$taskId)->first();
        $task->restore();


        return response()->noContent();
    }
}
