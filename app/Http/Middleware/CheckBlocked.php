<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guest())
            return redirect("/login");

        $user = User::find(Auth::user()->id);

        $start_blocked = $user->blocked_from ?? null;
        $end_blocked = $user->blocked_to ?? null;

        if (!is_null($start_blocked)&&!is_null($end_blocked)){

            $start_blocked = strtotime($start_blocked);
            $end_blocked = strtotime($end_blocked);

            if (Carbon::now()->timestamp >= $start_blocked && Carbon::now()->timestamp<$end_blocked)
                return redirect()->route("blocked");

        }


        return $next($request);
    }
}
