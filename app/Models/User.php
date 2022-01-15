<?php

namespace App\Models;

use App\DeviceGroup;
use App\History;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'blocked_from',
        'blocked_to',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function history()
    {
        return $this->hasMany(History::class, "user_id", "id");
    }

    public function device_groups()
    {

        return $this->belongsToMany(DeviceGroup::class, 'user_has_device_groups', 'user_id', 'device_group_id')
            ->withTimestamps();

    }

    public static function selfPermissions()
    {

        $role_id = DB::table("model_has_roles")->where("model_id", Auth::user()->id)->first()->role_id;

        $permissions = Role::with(["permissions"])->where("id", $role_id)->first()->permissions;

        return $permissions;


    }
}
