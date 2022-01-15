<?php

namespace App\Http\Controllers;

use App\Boundary;
use App\BoundarySchedule;
use App\Classes\OperationHistory;
use App\Device;
use App\Enums\ModelType;
use App\Exports\BoundaryScheduleMovableExport;
use App\Exports\BoundaryScheduleStaticExport;
use App\Http\Requests\BoundaryScheduleStoreRequest;
use App\Http\Resources\BoundaryCollection;
use App\Http\Resources\BoundaryScheduleCollection;
use App\Http\Resources\BoundaryScheduleResource;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BoundaryScheduleController extends Controller
{

    use OperationHistory;

    public function __construct()
    {

        $this->middleware('permission:Просмотр расписания рубежей')
            ->only('index', 'show', 'scheduleDownload', 'getBoundarySchedulerMovable');

        $this->middleware('permission:Добавление расписания рубежей')->only('store', 'create');
        $this->middleware('permission:Удаление расписания рубежей')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение расписания рубежей')->only('update');
        $this->middleware('permission:Восстановление расписания рубежей')->only('restore');
    }

    public function getFilteredStaticSchedule(Request $request)
    {
        $request->validate([
            "start_date" => "required",
            "end_date" => "required",
            /*"devices" => "required",
            "device_groups" => "required",
            "boundaries" => "required",*/
        ]);

        $tmp_boundaries_id = null;

        $start_month = Carbon::parse($request->start_date)->month ?? null;
        $start_day = Carbon::parse($request->start_date)->day ?? null;
        $end_month = Carbon::parse($request->end_date)->month ?? null;
        $end_day = Carbon::parse($request->end_date)->day ?? null;

        for ($i = $start_month; $i <= $end_month; $i++)
            $this->prepareMonthShedule($i);

        $tmp_filtered_boundaries = null;


        $tmp_filtered_boundaries = Device::whereIn("device_boundary_id", $request->boundaries ?? [])
            ->orWhereIn("id", (array)$request->devices ?? [])
            ->orWhereIn("device_group_id", (array)$request->device_groups ?? [])
            ->distinct()
            ->get();

        $tmp_boundaries_id = $request->boundaries ?? [];


        foreach ($tmp_filtered_boundaries as $tmp) {
            if (!is_null($tmp->device_boundary_id))
                array_push($tmp_boundaries_id, $tmp->device_boundary_id);

        }


        $dateS = is_null($start_month) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($start_month)->setDay($start_day);//->subMonth(1);
        $dateE = is_null($end_month) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($end_month)->setDay($end_day);

        $bs = Boundary::where("movable", false)
            ->whereBetween("created_at", [$dateS, $dateE])
            //->orWhereBetween("install_date", [$dateS, $dateE])
            ->orderBy("created_at", "asc");


        if (count($tmp_boundaries_id) > 0)
            $bs = $bs->orWhereIn("id", $tmp_boundaries_id);

        $bs = $bs->get();

        return new BoundaryCollection($bs);
    }

    public function getFilteredMovabaleSchedule(Request $request)
    {
        $request->validate([
            "start_date" => "required",
            "end_date" => "required",
            /*"devices" => "required",
            "device_groups" => "required",
            "boundaries" => "required",*/
        ]);

        $tmp_boundaries_id = null;

        $start_month = Carbon::parse($request->start_date)->month ?? null;
        $start_day = Carbon::parse($request->start_date)->day ?? null;
        $end_month = Carbon::parse($request->end_date)->month ?? null;
        $end_day = Carbon::parse($request->end_date)->day ?? null;

        for ($i = $start_month; $i <= $end_month; $i++)
            $this->prepareMonthShedule($i);

        $tmp_filtered_boundaries = null;


        $tmp_filtered_boundaries = Device::whereIn("device_boundary_id", $request->boundaries ?? [])
            ->orWhereIn("id", (array)$request->devices ?? [])
            ->orWhereIn("device_group_id", (array)$request->device_groups ?? [])
            ->distinct()
            ->get();

        $tmp_boundaries_id = $request->boundaries ?? [];


        foreach ($tmp_filtered_boundaries as $tmp) {
            if (!is_null($tmp->device_boundary_id))
                array_push($tmp_boundaries_id, $tmp->device_boundary_id);

        }


        $dateS = is_null($start_month) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($start_month)->setDay($start_day);//->subMonth(1);
        $dateE = is_null($end_month) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($end_month)->setDay($end_day);

        $bs = BoundarySchedule::with(["boundary"])
            ->where("type", 1)
            ->whereBetween("day", [$dateS, $dateE])
            ->orderBy("day", "asc")
            ->orderBy("boundary_id", "asc");

        Log::info("test=>" . print_r($tmp_boundaries_id, true));

        if (count($tmp_boundaries_id) > 0)
            $bs = $bs->whereIn("boundary_id", $tmp_boundaries_id);

        $bs = $bs->get();

        $tmp_boundaries_id = [];
        $tmp_boundaries = [];
        $tmp_dates = [];

        $rows = [];
        $tmp_row = [];
        $current_day = null;
        foreach ($bs as $item) {

            if (!in_array($item->boundary_id, $tmp_boundaries_id)) {
                array_push($tmp_boundaries_id, $item->boundary_id);
                array_push($tmp_boundaries, $item->boundary);
            }

            if (!in_array($item->day, $tmp_dates))
                array_push($tmp_dates, $item->day);

            if ($current_day != $item->day) {
                $current_day = $item->day;
                if (count($tmp_row) > 0)
                    array_push($rows, $tmp_row);

                $tmp_row = [];
            }
            array_push($tmp_row, $item);


        }
        array_push($rows, $tmp_row);

        return response()->json([
            "table" => $rows,
            "boundaries" => $tmp_boundaries,
            "dates" => $tmp_dates
        ]);//new BoundaryScheduleCollection($bs);

    }

    /**
     * Display a listing of the resource.
     *
     * @return BoundaryScheduleCollection
     */
    public function index($monthIndex = null)
    {
        $this->prepareMonthShedule($monthIndex);

        $dateS = is_null($monthIndex) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($monthIndex)->startOfMonth();//->subMonth(1);
        $dateE = is_null($monthIndex) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($monthIndex)->endOfMonth();

        $bs = BoundarySchedule::with(["boundary"])
            ->where("type", 1)
            ->whereBetween("day", [$dateS, $dateE])
            ->orderBy("day", "asc")
            ->orderBy("boundary_id", "asc")
            ->get();

        $tmp_boundaries_id = [];
        $tmp_boundaries = [];
        $tmp_dates = [];

        $rows = [];
        $tmp_row = [];
        $current_day = null;
        foreach ($bs as $item) {

            if (!in_array($item->boundary_id, $tmp_boundaries_id)) {
                array_push($tmp_boundaries_id, $item->boundary_id);
                array_push($tmp_boundaries, $item->boundary);
            }

            if (!in_array($item->day, $tmp_dates))
                array_push($tmp_dates, $item->day);

            if ($current_day != $item->day) {
                $current_day = $item->day;
                if (count($tmp_row) > 0)
                    array_push($rows, $tmp_row);

                $tmp_row = [];
            }
            array_push($tmp_row, $item);


        }
        array_push($rows, $tmp_row);

        return response()->json([
            "table" => $rows,
            "boundaries" => $tmp_boundaries,
            "dates" => $tmp_dates
        ]);//new BoundaryScheduleCollection($bs);
    }

    private function prepareMonthShedule($monthIndex = null)
    {

        $dateS = is_null($monthIndex) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($monthIndex)->startOfMonth();//->subMonth(1);
        $dateE = is_null($monthIndex) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($monthIndex)->endOfMonth();

        $bs = BoundarySchedule::where("type", 1)
            ->whereBetween("day", [$dateS, $dateE])
            ->orderBy("day", "asc")
            ->get();

        $tmp_days = [];

        $tmp_boundaries = [];

        foreach ($bs as $item) {
            $day = Carbon::parse($item->start_at)->day;

            if (!in_array($day, $tmp_days)) {
                array_push($tmp_days, $day);
            }

            if (!in_array($item->boundary_id, $tmp_boundaries))
                array_push($tmp_boundaries, $item->boundary_id);

        }

        $daysInMonth = is_null($monthIndex) ? Carbon::now()->daysInMonth : Carbon::now()->setMonth($monthIndex)->daysInMonth;


        $test_boundaries = Boundary::where("movable", 0)
            ->whereIn("id", $tmp_boundaries)
            ->get();


        if (count($test_boundaries) > 0)
            foreach ($test_boundaries as $boundary) {

                $tmp_rows = BoundarySchedule::where("boundary_id", $boundary->id)->get();
                foreach ($tmp_rows as $tmp)
                    $tmp->delete();

                unset($tmp_boundaries[array_search($boundary->id, $tmp_boundaries)]);
            }

        $boundaries = Boundary::where("movable", 1)
            ->whereNotIn("id", $tmp_boundaries)
            ->get();


        for ($i = 1; $i <= $daysInMonth; $i++) {

            if (in_array($i, $tmp_days) && count($boundaries) == 0)
                continue;

            foreach ($boundaries as $boundary) {
                BoundarySchedule::create([
                    "type" => 1,
                    "day" => is_null($monthIndex) ? Carbon::now()->day($i)->startOfDay() : Carbon::now()->setMonth($monthIndex)->day($i)->startOfDay(),
                    "start_at" => is_null($monthIndex) ? Carbon::now()->day($i)->startOfDay() : Carbon::now()->setMonth($monthIndex)->day($i)->startOfDay(),
                    "end_at" => is_null($monthIndex) ? Carbon::now()->day($i)->endOfDay() : Carbon::now()->setMonth($monthIndex)->day($i)->endOfDay(),
                    "boundary_id" => $boundary->id,
                    "is_installed" => false,
                    "address" => "",
                ]);
            }

        }
    }

    public function getBoundaryScheduleMovable($monthIndex = null)
    {

        $dateS = is_null($monthIndex) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($monthIndex)->startOfMonth();//->subMonth(1);
        $dateE = is_null($monthIndex) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($monthIndex)->endOfMonth();

        $this->prepareMonthShedule($monthIndex);

        $bs = BoundarySchedule::where("type", 1)
            ->whereBetween("day", [$dateS, $dateE])
            ->orderBy("day", "asc")
            ->get();


        return new BoundaryScheduleCollection($bs);
    }


    public function getBoundaryScheduleStatic()
    {

        $boundaries = Boundary::where("movable", false)->get();

        return new BoundaryCollection($boundaries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return BoundaryScheduleResource
     */
    public function store(BoundaryScheduleStoreRequest $request)
    {
        $bs = BoundarySchedule::create($request->validated());

        $this->setAfter((object)$bs);
        $this->saveHistory("Создание", ModelType::BoundarySchedule);

        return new BoundaryScheduleResource($bs);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BoundarySchedule $boundariesSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(BoundarySchedule $boundariesSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\BoundarySchedule $boundariesSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(BoundarySchedule $boundariesSchedule)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BoundarySchedule $boundariesSchedule
     * @return BoundaryScheduleResource
     */
    public function update(Request $request, $id)
    {
        $bs = BoundarySchedule::find($id);

        Log::info($request->start_time_h . " " . $request->start_time_m . " " . $request->end_time_h . " " . $request->end_time_m);

        $tmp_date_start = Carbon::parse($bs->start_at)->setTime($request->start_time_h, $request->start_time_m);
        $tmp_date_end = Carbon::parse($bs->end_at)->setTime($request->end_time_h, $request->end_time_m);


        $this->setBefore((object)$bs);

        $bs->update($request->all());

        $bs->start_at = $tmp_date_start;
        $bs->end_at = $tmp_date_end;
        $bs->save();


        Log::info("Updating for $id");

        $this->setAfter((object)$bs);
        $this->saveHistory("Обновление", ModelType::BoundarySchedule);

        return new BoundaryScheduleResource($bs);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BoundarySchedule $boundariesSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bs = BoundarySchedule::find(id);

        $this->setBefore((object)$bs);

        $bs->delete();

        $this->setAfter((object)$bs);
        $this->saveHistory("Удаление", ModelType::BoundarySchedule);

        return response()->noContent();
    }

    public function scheduleMovableDownload(Request $request)
    {

        $request->validate([
            "start_date" => "required",
            "end_date" => "required",
            /*"devices" => "required",
            "device_groups" => "required",
            "boundaries" => "required",*/
        ]);

        $tmp_boundaries_id = null;

        $start_month = Carbon::parse($request->start_date)->month ?? null;
        $start_day = Carbon::parse($request->start_date)->day ?? null;
        $end_month = Carbon::parse($request->end_date)->month ?? null;
        $end_day = Carbon::parse($request->end_date)->day ?? null;

        for ($i = $start_month; $i <= $end_month; $i++)
            $this->prepareMonthShedule($i);

        $tmp_filtered_boundaries = null;


        $tmp_filtered_boundaries = Device::whereIn("device_boundary_id", $request->boundaries ?? [])
            ->orWhereIn("id", (array)$request->devices ?? [])
            ->orWhereIn("device_group_id", (array)$request->device_groups ?? [])
            ->distinct()
            ->get();

        $tmp_boundaries_id = $request->boundaries ?? [];


        foreach ($tmp_filtered_boundaries as $tmp) {
            if (!is_null($tmp->device_boundary_id))
                array_push($tmp_boundaries_id, $tmp->device_boundary_id);

        }


        $dateS = is_null($start_month) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($start_month)->setDay($start_day);//->subMonth(1);
        $dateE = is_null($end_month) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($end_month)->setDay($end_day);

        $bs = BoundarySchedule::with(["boundary"])
            ->where("type", 1)
            ->whereBetween("day", [$dateS, $dateE])
            ->orderBy("day", "asc")
            ->orderBy("boundary_id", "asc");

        Log::info("test=>" . print_r($tmp_boundaries_id, true));

        if (count($tmp_boundaries_id) > 0)
            $bs = $bs->whereIn("boundary_id", $tmp_boundaries_id);

        $bs = $bs->get();

        $tmp_boundaries_id = [];
        $tmp_boundaries = [];
        $tmp_dates = [];

        $rows = [];
        $tmp_row = [];
        $current_day = null;
        foreach ($bs as $item) {

            if (!in_array($item->boundary_id, $tmp_boundaries_id)) {
                array_push($tmp_boundaries_id, $item->boundary_id);
                array_push($tmp_boundaries, $item->boundary);
            }

            if (!in_array($item->day, $tmp_dates))
                array_push($tmp_dates, $item->day);

            if ($current_day != $item->day) {
                $current_day = $item->day;
                if (count($tmp_row) > 0)
                    array_push($rows, $tmp_row);

                $tmp_row = [];
            }
            array_push($tmp_row, $item);


        }
        array_push($rows, $tmp_row);

        $date = Carbon::now();

        return Excel::download(new BoundaryScheduleMovableExport($rows, $tmp_dates, $tmp_boundaries), "schedule-$date.xlsx");
    }

    public function scheduleStaticDownload(Request $request)
    {

        $request->validate([
            "start_date" => "required",
            "end_date" => "required",
            /*"devices" => "required",
            "device_groups" => "required",
            "boundaries" => "required",*/
        ]);

        $tmp_boundaries_id = null;

        $start_month = Carbon::parse($request->start_date)->month ?? null;
        $start_day = Carbon::parse($request->start_date)->day ?? null;
        $end_month = Carbon::parse($request->end_date)->month ?? null;
        $end_day = Carbon::parse($request->end_date)->day ?? null;

        for ($i = $start_month; $i <= $end_month; $i++)
            $this->prepareMonthShedule($i);

        $tmp_filtered_boundaries = null;


        $tmp_filtered_boundaries = Device::whereIn("device_boundary_id", $request->boundaries ?? [])
            ->orWhereIn("id", (array)$request->devices ?? [])
            ->orWhereIn("device_group_id", (array)$request->device_groups ?? [])
            ->distinct()
            ->get();

        $tmp_boundaries_id = $request->boundaries ?? [];


        foreach ($tmp_filtered_boundaries as $tmp) {
            if (!is_null($tmp->device_boundary_id))
                array_push($tmp_boundaries_id, $tmp->device_boundary_id);

        }


        $dateS = is_null($start_month) ? Carbon::now()->startOfMonth() : Carbon::now()->setMonth($start_month)->setDay($start_day);//->subMonth(1);
        $dateE = is_null($end_month) ? Carbon::now()->endOfMonth() : Carbon::now()->setMonth($end_month)->setDay($end_day);

        $bs = Boundary::where("movable", false)
            ->whereBetween("created_at", [$dateS, $dateE])
            ->orWhereBetween("install_date", [$dateS, $dateE])
            ->orderBy("created_at", "asc");


        if (count($tmp_boundaries_id) > 0)
            $bs = $bs->whereIn("id", $tmp_boundaries_id);

        $bs = $bs->get();



        $date = Carbon::now();

        return Excel::download(new BoundaryScheduleStaticExport($bs), "schedule-$date.xlsx");
    }
}
