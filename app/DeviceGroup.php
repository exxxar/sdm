<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceGroup extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'deleted_at',
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function devices()
    {
        return $this->hasMany(\App\Device::class);
    }

    public function devicesWithTrashed()
    {
        return $this->hasMany(\App\Device::class)->withTrashed();
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_has_device_groups','device_group_id','user_id')
            ->withTimestamps();
    }
}
