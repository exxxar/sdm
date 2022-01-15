<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Report;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр ролей')->only('index','show');
        $this->middleware('permission:Удаление ролей')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение ролей')->only('update','edit');
        $this->middleware('permission:Восстановление ролей')->only('restore');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with(["permissions"])->get();
        $permissions = Permission::all();

        return response()->json(
            [
                "roles"=>new RoleCollection($roles),
                "permissions"=>new PermissionCollection($permissions)
            ]
        );

    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->title]);

        $this->setAfter((object)$role);

        if(count($request->permissions))
        {
            $role->syncPermissions($request->permissions);
        }


        $this->setAfter((object)$role);
        $this->saveHistory("Создание", ModelType::Role);

        return response()->noContent();
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        $this->setBefore((object)$role);

        $role->syncPermissions($request->permissions);

        $this->setAfter((object)$role);
        $this->saveHistory("Редактирование", ModelType::Role);

        return response()->noContent();
    }

    /**
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keep_roles_array = [1,2,3,4];

        if (in_array($id,$keep_roles_array) )
            return response()->setStatusCode(403);

        $role=Role::find($id);
        $this->setBefore((object)$role);

        $role->permissions()->detach();
        $role->users()->detach();
        $role->delete();

        $this->setAfter((object)$role);
        $this->saveHistory("Удаление", ModelType::Role);

        return response()->noContent();
    }

    public function giveRoleToUser(Request $request, $id){
        $user = User::find($id);

        $role = Role::where("name",$request->role)->first();

        $this->setBefore((object)$role);
        $this->setAfter((object)$role);
        $this->saveHistory("Добавление роли пользователю", ModelType::Role);

        $this->setAfter((object)$user);
        $user->syncRoles([$role->id]);
        $user->save();

        $this->setAfter((object)$user);
        $this->saveHistory("Добавление роли пользователю", ModelType::User);

        return response()->noContent();
    }
}
