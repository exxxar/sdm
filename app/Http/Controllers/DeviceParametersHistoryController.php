<?php

namespace App\Http\Controllers;

use App\Boundary;
use App\Classes\OperationHistory;
use App\Device;
use App\Enums\ModelType;
use App\Exports\SummaryExport;
use App\Http\Requests\DeviceParametersHistoryStoreRequest;
use App\Http\Requests\DeviceParametersHistoryUpdateRequest;
use App\Http\Resources\DeviceParametersHistoryCollection;
use App\Http\Resources\DeviceParametersHistoryResource;
use App\Classes\Utilites;
use App\DeviceParametersHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DeviceParametersHistoryController extends Controller
{
    use Utilites, OperationHistory;

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DeviceParametersHistoryCollection
     */
    public function index(Request $request)
    {
        $deviceParametersHistories = DeviceParametersHistory::all();

        return new DeviceParametersHistoryCollection($deviceParametersHistories);
    }

    /**
     * @param \App\Http\Requests\DeviceParametersHistoryStoreRequest $request
     * @return \App\Http\Resources\DeviceParametersHistoryResource
     */
    public function store(DeviceParametersHistoryStoreRequest $request)
    {
        $deviceParametersHistory = DeviceParametersHistory::create($request->validated());

        $this->setAfter((object)$deviceParametersHistory);
        $this->saveHistory("Создание", ModelType::DeviceParametersHistory);

        return new DeviceParametersHistoryResource($deviceParametersHistory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeviceParametersHistory $deviceParametersHistory
     * @return \App\Http\Resources\DeviceParametersHistoryResource
     */
    public function show(Request $request, DeviceParametersHistory $deviceParametersHistory)
    {
        return new DeviceParametersHistoryResource($deviceParametersHistory);
    }

    /**
     * @param \App\Http\Requests\DeviceParametersHistoryUpdateRequest $request
     * @param \App\DeviceParametersHistory $deviceParametersHistory
     * @return \App\Http\Resources\DeviceParametersHistoryResource
     */
    public function update(DeviceParametersHistoryUpdateRequest $request, DeviceParametersHistory $deviceParametersHistory)
    {
        $this->setBefore((object)$deviceParametersHistory);

        $deviceParametersHistory->update($request->validated());

        $this->setAfter((object)$deviceParametersHistory);
        $this->saveHistory("Редактирование", ModelType::DeviceParametersHistory);

        return new DeviceParametersHistoryResource($deviceParametersHistory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DeviceParametersHistory $deviceParametersHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DeviceParametersHistory $deviceParametersHistory)
    {
        $this->setBefore((object)$deviceParametersHistory);

        $deviceParametersHistory->delete();

        $this->setAfter((object)$deviceParametersHistory);
        $this->saveHistory("Редактирование", ModelType::DeviceParametersHistory);

        return response()->noContent();
    }

    public function getSummary(Request $request)
    {
        $ids = $request->ids;
        $groups = $request->groups ?? [];
        $type = $request->type;

        if ($type == "-1") {
            // рубежи
            $boundaries = Boundary::whereIn('id', $ids)->get();
            $temporary_ids = [];

            foreach ($boundaries as $key => $boundary) {
                foreach ($boundary->devices as $key => $boundary_device) {
                    array_push($temporary_ids, $boundary_device->id);
                }
            }

            $ids = $temporary_ids;
        }

        $startDate = Carbon::parse($request->startDate)->setTimezone('Europe/Moscow')->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($request->endDate)->setTimezone('Europe/Moscow')->format('Y-m-d H:i:s');
        $device_parameters_history = DeviceParametersHistory::with(['device', 'device.deviceBoundary:id,title'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        //->orderBy('device.device_type_id');

        if (count($groups) > 0) {
            $device_ids = Device::whereIn("device_group_id", $groups)
                ->orderBy("device_type_id", "asc");
            //->groupBy("device_type_id")

            if (!empty($type)) {
                $device_ids = $device_ids->where("device_type_id", $type);
            }

            $device_ids = $device_ids->pluck("id");

            $ids = $device_ids->toArray();

        }

        //   $ids = $device_ids;
        $device_parameters_history = $device_parameters_history->whereIn("device_id", $ids);


        $device_parameters_history = $device_parameters_history
            ->get();


        $history_grouped_by_date = $this->getDeviceParametersHistoryGroupedByDate($device_parameters_history);
        $history_grouped_by_device = $this->getDeviceParametersHistoryGroupedByDevice($device_parameters_history);
        $records = $this->getSummaryRecords($history_grouped_by_date, $history_grouped_by_device);

        if ($type == "-1") {
            $records = $this->replaceDeviceWithBoundariesTable($records);
            $history_grouped_by_device = $this->replaceDeviceWithBoundariesChart($history_grouped_by_device);
        }

        // temporary fix
        if (count($history_grouped_by_device) > 0 && $type != "-1") {


            foreach ($ids as $key => $device_id) {
                $device = Device::withTrashed()->find($device_id);

                $key = array_search($device->serial, array_column($history_grouped_by_device, 'name'));

                if (!$key) {
                    $object = (object)[
                        'name' => $device->serial,
                        'dates' => []
                    ];

                    array_push($history_grouped_by_device, $object);
                }
            }
        }

        if (count($records) > 0 && $type != "-1") {
            /*
                        $ids = (Device::withTrashed()->whereIn("id",$ids)->orderBy("device_type_id","ASC")->pluck("id"))->toArray();*/


            foreach ($ids as $key => $device_id) {
                $device = Device::withTrashed()->find($device_id);

                if (!property_exists($records[0], $device->serial)) {
                    foreach ($records as $record) {
                        $record->{$device->serial} = (object)[
                            "violations" => 0,
                            "passages" => 0,
                            "status" => "error",
                            "ping" => 0,
                            "voltage" > 0,
                            "passages24" => 0,
                            "violations24" => 0,
                            "data" => null,
                            "device_type_id" => $device->device_type_id
                        ];
                    }
                }
            }
        }
        // temporary fix


        /*  $records = collect(((array)$records[0]))->sortBy(function ($data) {
              dd($data);
                  return $data->name;
          })->toArray();*/
        return response()
            ->json([
                'charts' => $history_grouped_by_device,
                'records' => $records,
                "status" => 200,
            ]);
    }

    public function getDateRangeForSummaryByPeriod(Request $request)
    {
        $date_range = $this->getDateRangeByPeriod($request->period, $request->startDate, $request->endDate);
        return response()
            ->json([
                'date_range' => $date_range,
                "status" => 200,
            ]);
    }

    public function downloadSummary(Request $request)
    {
        $report_name = 'Summary' . Carbon::now()->format('d.m.Y') . '.xlsx';

        $date_range = $this->getDateRangeByPeriod($request->period, $request->startDate, $request->endDate);

        $startDate = Carbon::parse($date_range->startDate)->setTimezone('Europe/Moscow')->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($date_range->endDate)->setTimezone('Europe/Moscow')->format('Y-m-d H:i:s');

        $device_parameters_history = DeviceParametersHistory::with(['device', 'device.deviceBoundary:id,title'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('device_id', $request->ids)
            ->get();


        $history_grouped_by_date = $this->getDeviceParametersHistoryGroupedByDate($device_parameters_history);
        $history_grouped_by_device = $this->getDeviceParametersHistoryGroupedByDevice($device_parameters_history);

        /*       $history_grouped_by_device = collect($history_grouped_by_device)->sortBy(function ($data){
                   return $data->dates[0]->device_type_id;
               })->reverse()->toArray();*/
        //$this->saveHistory("Экспорт в эксель файл", ModelType::DeviceParametersHistory);

        return Excel::download(new SummaryExport($history_grouped_by_date, $history_grouped_by_device), $report_name);
    }
}
