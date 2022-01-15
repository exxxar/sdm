<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoundaryGroup extends Model
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
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function boundaries()
    {
        return $this->hasMany(\App\Boundary::class);
    }

    public function devicesCount()
    {
        $amount = 0;

        foreach ($this->boundaries as $key => $boundary) {
            $amount = $amount + $boundary->devices->count();
        }

        return $amount;
    }
}
