<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceParametersHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'violations',
        'passages',
        'status',
        'ping',
        'voltage',
        'additional_data',
        'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'device_id' => 'integer',
        'voltage' => 'double',
        'additional_data'=>'array'
    ];


    public function device()
    {
        return $this->belongsTo(\App\Device::class)->withTrashed();
    }
}
