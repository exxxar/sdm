<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'serial',
        'ip',
        'device_group_id',
        'device_boundary_id',
        'lat',
        'lon',
        'location_id',
        'device_type_id',
        'region_id',
        'connection',
        'port',
        'login',
        'password',
        'secret',
        'installation_date',
        'withdrawal_date',
        'deleted_at',
        'properties',
        'mobile',
        'is_active',
        'movable'
    ];

//    /**
//     * The attributes that should be cast to native types.
//     *
//     * @var array
//     */
//    protected $casts = [
//        'id' => 'integer',
//        'is_active' => 'boolean',
//        'device_type_id' => 'integer',
//        'deleted_at' => 'timestamp',
//        'properties' => 'array',
//        'region_id' => 'integer',
//        'last_poll_at' => 'timestamp',
//        'device_boundary_id' => 'integer',
//        'mobile' => 'boolean',
//    ];


    protected $appends = [
        "passages_day", "violations_day",
        "passages", "violations",
        "is_alive", "ping"

    ];

    public function scopeWithSort($query, $sort, $sortDirection)
    {
        return $query->orderBy($sort, $sortDirection);
    }

    public function scopeWithFilters($query, $filters)
    {
        return $query->when($filters->deleted, function ($query) {
            $query->withTrashed();
        })->when($filters->serial, function ($query) use ($filters) {
            $query->where('serial', 'LIKE', '%' . $filters->serial . '%');
        })->when($filters->boundary, function ($query) use ($filters) {
            $query->whereHas('deviceBoundary', function ($query) use ($filters) {
                return $query->where('title', 'like', '%' . $filters->boundary . '%');
            });
        })->when($filters->group, function ($query) use ($filters) {
            $query->where('device_group_id', $filters->group);
        })->when($filters->type, function ($query) use ($filters) {
            $query->where('device_type_id', $filters->type);
        })->when($filters->device_class, function ($query) use ($filters) {
            switch ($filters->device_class) {
                case '1':
                    $query->where('mobile', false);
                    break;
                case '2':
                    $query->where('mobile', true)->where('movable', false);
                    break;
                case '3':
                    $query->where('mobile', true)->where('movable', true);
                    break;
                default:
                    # nothing
                    break;
            }
        });
    }

    public function getPingAttribute()
    {
        $dh = DeviceParametersHistory::where("device_id", $this->id)
            ->whereBetween("created_at", [
                Carbon::now()->startOfHour()->minute(0)->second(0),
                Carbon::now()->endOfHour()->minute(59)->second(59)
            ])
            ->orderBy("id", "desc")
            ->first();

        if (is_null($dh))
            return "отсутствует,";

        if ($dh->ping == 0)
            return "отсутствует,";

        return $dh->ping ?? "отсутствует,";

    }

    public function getViolationsByPeriod($startTime, $endTime): int
    {
        $sum = 0;
        $deviceParametersHistories = $this->deviceParametersHistory->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime);

        foreach ($deviceParametersHistories as $key => $history) {
            $sum += $history->violations;
        }

        return $sum;
    }

    public function getPassagesByPeriod($startTime, $endTime): int
    {
        $sum = 0;

        $sum = 0;
        $deviceParametersHistories = $this->deviceParametersHistory->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime);

        /*if ($this->device_type_id==3)
        $deviceParametersHistories = $this->deviceParametersHistory
            ->whereBetween("created_at",[$startTime, $endTime])
            ->sum("passages");*/

        foreach ($deviceParametersHistories as $key => $history) {
            $sum += $history->passages;
        }

        return $sum;
    }

    public function getIsAliveAttribute()
    {
        $dhs = DeviceParametersHistory::where("device_id", $this->id)
            ->whereBetween("created_at", [
                Carbon::now()->startOfHour()->minute(0)->second(0),
                Carbon::now()->endOfHour()->minute(59)->second(59)
            ])
            ->orderBy("id", "desc")
            ->first();


        return !is_null($dhs) ? $dhs->ping > 0 || $dhs->voltage > 0 : false;

    }

    public function getPassagesAttribute()
    {
        return 0;

    }

    public function getViolationsAttribute()
    {
        /*if ($this->device_type_id == 3) {
            $sum = 0;
            for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {

                $passages = DeviceParametersHistory::where("device_id", $this->id)
                        ->whereBetween("created_at", [
                            Carbon::now()->startOfMonth()->day($i)->hour(0)->minute(0)->second(0),
                            Carbon::now()->startOfMonth()->day($i)->hour(23)->minute(59)->second(59)
                        ])
                        ->sum('violations') ?? 0;

                $sum += $passages;
            }

            return $sum;
        } else {
            $sum = 0;
            for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {

                $passages = DeviceParametersHistory::where("device_id", $this->id)
                        ->whereBetween("created_at", [
                            Carbon::now()->startOfMonth()->day($i)->hour(0)->minute(0)->second(0),
                            Carbon::now()->startOfMonth()->day($i)->hour(23)->minute(59)->second(59)
                        ])
                        ->max('violations') ?? 0;

                $sum += $passages;
            }

            return $sum;
        }*/

        return 0;
    }


    public function getPassagesDayAttribute()
    {
        if ($this->device_type_id == 3) {
            return DeviceParametersHistory::where("device_id", $this->id)
                    ->whereBetween("created_at", [
                        Carbon::now()->startOfDay()->hour(0)->minute(0)->second(0),
                        Carbon::now()->endOfDay()->hour(23)->minute(59)->second(59)
                    ])
                    ->sum("passages") ?? 0;
        } else {
            return DeviceParametersHistory::where("device_id", $this->id)
                    ->whereBetween("created_at", [
                        Carbon::now()->startOfDay()->minute(0)->second(0),
                        Carbon::now()->endOfDay()->minute(59)->second(59)
                    ])
                    ->max("passages") ?? 0;
        }


    }


    public function getViolationsDayAttribute()
    {


        if ($this->device_type_id == 3) {
            return DeviceParametersHistory::where("device_id", $this->id)
                    ->whereBetween("created_at", [
                        Carbon::now()->startOfDay()->minute(0)->second(0),
                        Carbon::now()->endOfDay()->minute(59)->second(59)
                    ])
                    ->sum("violations") ?? 0;
        } else {
            return DeviceParametersHistory::where("device_id", $this->id)
                    ->whereBetween("created_at", [
                        Carbon::now()->startOfDay()->minute(0)->second(0),
                        Carbon::now()->endOfDay()->minute(59)->second(59)
                    ])
                    ->max("violations") ?? 0;
        }
    }

    public function deviceType()
    {
        return $this->belongsTo(\App\DeviceType::class);
    }

    public function region()
    {
        return $this->belongsTo(\App\Region::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, "location_id");
    }

    public function group()
    {
        return $this->belongsTo(\App\DeviceGroup::class, 'device_group_id')->withTrashed();
    }

    public function appeals()
    {
        return $this->hasMany(\App\Task::class, 'device_id', 'id')->withTrashed();
    }

    public function deviceBoundary()
    {
        return $this->belongsTo(\App\Boundary::class, 'device_boundary_id')->withTrashed();
    }

    public function deviceCoordsHistory()
    {
        return $this->hasMany(\App\Models\DeviceCoordsHistory::class, 'device_id', 'id')->orderBy('created_at', 'desc');;
    }

    public function deviceParametersHistory()
    {
        return $this->hasMany(\App\DeviceParametersHistory::class, 'device_id', 'id');
    }

    public function getCertificateAttribute(): int
    {
        if ($this->device_type_id != 2) {
            return -1;
        }

        $lastLoggedDeviceParameterHistory = $this->deviceParametersHistory->last();

        if (!$lastLoggedDeviceParameterHistory || !$lastLoggedDeviceParameterHistory->additional_data) {
            return -1;
        }

        $fixing = $lastLoggedDeviceParameterHistory->additional_data['fixing'];//json_decode($content);
        $certificate = $fixing['certificate'];
        $expire = $certificate['expire'];
        $currentTime = Carbon::now()->getTimestamp();

        $remainSeconds = $expire - $currentTime;

        if ($remainSeconds <= 0) {
            return -2;
        }

        $remainDays = intval($remainSeconds / 86400);

        return $remainDays;
    }
}
