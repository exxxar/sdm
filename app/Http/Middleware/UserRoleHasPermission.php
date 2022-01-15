<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;

class UserRoleHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $per)
    {

        if (Auth::guest())
            return redirect("/login");

        Log::info("User_id=>".$request->user()->id);

        $user = User::with(["roles"])->whereId($request->user()->id)->first();



        $role_id = $user->roles[0]->id;

        Log::info("Role_id=>".$role_id." permission to check=>$per");

        $permission = Permission::where("name", $per)->first();

        if (is_null($permission))
            throw UnauthorizedException::forRoles([$user->roles[0]]);

        $r = DB::table("role_has_permissions")
            ->where("role_id", $role_id)
            ->where("permission_id", $permission->id)->first();


        if (is_null($r)) {
            throw UnauthorizedException::forPermissions([$permission]);
        }

        return $next($request);
    }
}
