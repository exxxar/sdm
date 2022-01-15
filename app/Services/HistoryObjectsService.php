<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

class HistoryObjectsService
{
    public static function getHistoryObjects() : array
    {
        $historyTypes = DB::table('history_types')->get();
        $historyObjects = [];

        foreach ($historyTypes as $key => $historyType) {
            if (empty($historyType->title) || is_null($historyType->title) || str_contains($historyType->title, 'История')) {
                continue;
            }

            $currentResolvedObject = self::historyObjectFactory($historyType->model_type);

            $items = [];

            if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($currentResolvedObject))) {
                $items = $currentResolvedObject::withTrashed()->get();
            } else {
                $items = $currentResolvedObject::all();
            }

            $historyObjects[$historyType->array_title] = (object)[
                "type_id" => $historyType->id,
                "title" => $historyType->title,
                "items" => $items,
            ];
        }

        return $historyObjects;
    }

    public static function historyObjectFactory($path)
    {
        return resolve($path);
    }
}