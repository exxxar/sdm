<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Symfony\Component\Translation\t;

class BoundarySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        "type",
        "day",
        "start_at",
        "end_at",
        "boundary_id",
        "is_installed",
        "address",
    ];

    protected $casts = [
        "start_at"=>"datetime",
        "end_at"=>"datetime",
        "boundary_id"=>"integer",
        "is_installed"=>"boolean",
    ];


    public function boundary(){
        return $this->hasOne(Boundary::class,"id","boundary_id");
    }


}
