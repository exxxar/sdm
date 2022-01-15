<?php

namespace App;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boundary_id',
        'device_id',
        'malfunction_id',
        'user_id',
        'responsible_id',
        'started_at',
        'executed_at',
        'note',
        'notes',
        'deleted_at',
        'status',
        'custom_reason',
        'report_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp:Y-m-d H:i:s',
        'started_at' => 'timestamp:Y-m-d H:i:s',
        'executed_at' => 'timestamp:Y-m-d H:i:s',
        'updated_at' => 'timestamp:Y-m-d H:i:s',
        'notes' => 'array',
        /*'id' => 'integer',
        'user_id' => 'integer',
        'device_boundary_id' => 'integer',
        'device_id' => 'integer',
        'date_executed' => 'timestamp',
        'deleted_at' => 'timestamp',
        'task_status_id' => 'integer',*/
    ];

    public function scopeWithFilters($query, $filters)
    {
        return $query->when($filters->deleted, function ($query) {
            $query->withTrashed();
        })->when($filters->actual && !$filters->ready, function ($query) {
            $query->where('status', 'Актуальные');
        })->when($filters->ready && !$filters->actual, function ($query) {
            $query->where('status', 'Готово');
        })->when(!$filters->ready && !$filters->actual, function ($query) {
            $query->where('status', '');
        })->when($filters->boundary, function ($query) use ($filters){
            $query->whereHas('boundary', function ($query) use ($filters) {
                return $query->where('title', 'like', '%'.$filters->boundary.'%');
            });
        })->when($filters->malfunction, function ($query) use ($filters) {
            $query->where('malfunction_id', $filters->malfunction);
        })->when($filters->direction, function ($query) use ($filters) {
            $query->orderBy('status', $filters->direction);
        })->when($filters->device_id, function ($query) use ($filters) {
            $query->where('device_id', $filters->device_id);
        })->when($filters->boundary_id, function ($query) use ($filters) {
            $query->where('boundary_id', $filters->boundary_id);
        })->when($filters->task_id, function ($query) use ($filters) {
            $query->where('id', 'LIKE', '%'.$filters->task_id.'%');
        })->when($filters->start_date, function ($query) use ($filters) {
            $query->where('created_at', '>=', Carbon::parse($filters->start_date));
        })->when($filters->end_date, function ($query) use ($filters) {
            $query->where('created_at', '<=', Carbon::parse($filters->end_date));
        });
    }

    public function report()
    {
        return $this->hasOne(Report::class,"id","report_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boundary()
    {
        return $this->belongsTo(\App\Boundary::class)->withTrashed();
    }

    public function device()
    {
        return $this->belongsTo(\App\Device::class);
    }

    public function malfunction()
    {
        return $this->belongsTo(Dictionary::class);
    }

    /*public function taskStatus()
    {
        return $this->belongsTo(\App\TaskStatus::class);
    }*/
}
