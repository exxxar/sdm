<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boundary extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'boundary_group_id',
        'region_id',
        'deleted_at',
        'speed_mode',
        'lat',
        'lon',
        'mobile',
        'is_active',
        'movable',
        'uninstall_date',
        'install_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   protected $casts = [
       'is_active' => 'boolean',
        'mobile' => 'boolean',
        'movable' => 'boolean',

    ];

    protected $appends = [
        "passages", "violations","boundary_group_title","passages_day","violations_day"
    ];

    public function getBoundaryGroupTitleAttribute(){
        return $this->boundary_group->title??'';
    }

    public function getPassagesDayAttribute()
    {
        $devices = $this->devices;
        $sum = 0;

        foreach ($devices as $key => $device) {
            $sum += $device->getPassagesDayAttribute();
        }

        return $sum;
    }

    public function getViolationsDayAttribute()
    {
        $devices = $this->devices;
        $sum = 0;

        foreach ($devices as $key => $device) {
            $sum += $device->getViolationsDayAttribute();
        }

        return $sum;
    }

    public function getPassagesAttribute()
    {
        $devices = $this->devices;
        $sum = 0;

        foreach ($devices as $key => $device) {
            $sum += $device->getPassagesAttribute();
        }


        return $sum;

    }

    public function getViolationsAttribute()
    {
        $devices = $this->devices;
        $sum = 0;

        foreach ($devices as $key => $device) {
            $sum += $device->getViolationsAttribute();
        }


        return $sum;

    }

    public function region()
    {
        return $this->belongsTo(\App\Region::class);
    }

    public function boundary_group()
    {
        return $this->belongsTo(\App\BoundaryGroup::class, 'boundary_group_id', 'id');
    }

    public function boundaryGroup()
    {
        return $this->belongsTo(\App\BoundaryGroup::class, 'boundary_group_id', 'id');
    }
    public function devices()
    {
        return $this->hasMany(\App\Device::class, 'device_boundary_id');
    }

    public function dictionaries()
    {
        return $this->belongsToMany(Dictionary::class);
    }
}
