<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\Events\UserNotifyEvent;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\NotifyMail;
use App\Models\User;
use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр пользователей')->only('index', 'show');
        $this->middleware('permission:Добавление пользователей')->only('store');
        $this->middleware('permission:Удаление пользователей')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение пользователей')->only('update');
        $this->middleware('permission:Восстановление пользователей')->only('restore');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\UserCollection
     */
    public function index(Request $request)
    {
        $users = User::withTrashed()->get();

        return new UserCollection($users);
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());

        $user->password = bcrypt($request->password);

        if ($request->blocking) {
            $user->blocked_from = Carbon::parse($request->blocked_from) ?? Carbon::now();
            $user->blocked_to = Carbon::parse($request->blocked_to) ?? Carbon::now();
        } else {
            $user->blocked_from = null;
            $user->blocked_to = null;
        }
        $user->save();


        if (!is_null($request->role ?? null)) {
            $role = Role::where("name", $request->role)->first();

            if (is_null($role))
                return new UserResource($user);

            $user->syncRoles([$role->id]);
            $user->save();

        }

        if ($request->device_group_id) {
            $user->device_groups()->sync($request->device_group_id);
            $user->save();
        }

        if ($request->notify) {
            $data = array('login' => $request->get('email'), 'password' => $request->get('password'));
            Mail::to($user->email)->send(new WelcomeMail($data, 'Заявка принята!'));
        }
        $this->setAfter((object)$user);
        $this->saveHistory("Создание", ModelType::User);

        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \App\Http\Resources\UserResource
     */
    public function show(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\User $user
     * @return \App\Http\Resources\UserResource
     */
    public function update(Request $request, $id)
    {
        //$this->setBefore((object)User::find($user->id));

        $user = User::find($id);

        $tmp = (array)$request->all();

        unset($tmp["blocked_from"]);
        unset($tmp["blocked_to"]);

        $user->update($tmp);

        if ($request->blocking) {
            $user->blocked_from = Carbon::parse($request->blocked_from) ;
            $user->blocked_to = Carbon::parse($request->blocked_to) ;
        } else {
            $user->blocked_from = null;
            $user->blocked_to = null;
        }

        $user->save();

        if (!is_null($request->role ?? null)) {
            $role = Role::where("name", $request->role)->first();

            if (is_null($role))
                return new UserResource($user);

            $user->syncRoles([$role->id]);
            $user->save();

        }
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        if ($request->device_group_id) {
            $user->device_groups()->sync($request->device_group_id);
            $user->save();
        }

        if ($request->notify)
            event(new UserNotifyEvent("Вам обновили данные", $user->email));

        $this->setAfter((object)$user);
        $this->saveHistory("Обновление", ModelType::User);

        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->setBefore((object)$user);

        $user->delete();

        $this->setAfter((object)$user);
        $this->saveHistory("Удаление", ModelType::User);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Request $request, User $user)
    {
        $this->setBefore((object)$user);

        $user->forceDelete();

        $this->setAfter((object)$user);
        $this->saveHistory("Форсированное удаление", ModelType::User);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        $this->setBefore((object)$user);
        $user->restore();

        $this->setAfter((object)$user);
        $this->saveHistory("Восстановление пользователя", ModelType::User);

        return response()->noContent();
    }
}
