<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Classes\Utilites;
use App\Device;
use App\Enums\ModelType;
use App\Exports\ReportExport;
use App\Http\Requests\ReportStoreRequest;
use App\Http\Requests\ReportUpdateRequest;
use App\Http\Resources\ReportCollection;
use App\Http\Resources\ReportResource;
use App\Mail\ReportMail;
use App\DeviceParametersHistory;
use App\Models\Report;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    use Utilites, OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр отчетов')->only('index', 'show');
        $this->middleware('permission:Удаление отчетов')->only('destroy', 'forceDelete');
        $this->middleware('permission:Создание отчетов')->only('store', 'create');
        $this->middleware('permission:Изменение отчетов')->only('edit', 'update');
        $this->middleware('permission:Восстановление отчетов')->only('restore');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::all();

        return new ReportCollection($reports);
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
     * @param \App\Http\Requests\ReportStoreRequest $request
     * @return \App\Http\Resources\ReportResource
     */
    public function store(ReportStoreRequest $request)
    {
        $report = Report::create($request->validated());

        $this->setAfter((object)$report);
        $this->saveHistory("Создание", ModelType::Report);

        return new ReportResource($report);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Report $report
     * @return \App\Http\Resources\ReportResource
     */
    public function show(Request $request, Report $report)
    {
        return new ReportResource($report);
    }

    /**
     * @param \App\Http\Requests\ReportUpdateRequest $request
     * @param \App\Models\Report $report
     * @return \App\Http\Resources\ReportResource
     */
    public function update(ReportUpdateRequest $request, Report $report)
    {

        $this->setBefore((object)Report::find($report->id));

        $report->update($request->validated());

        $this->setAfter((object)$report);
        $this->saveHistory("Редактирование", ModelType::Report);


        return new ReportResource($report);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Report $report)
    {

        $this->setBefore((object)$report);

        $report->delete();

        $this->setAfter((object)$report);
        $this->saveHistory("Удаление", ModelType::Report);

        return response()->noContent();
    }

    public function sendReportToEmails(Request $request)
    {
        $report = Report::find($request->id);
        $report_name = $report->title.Carbon::now()->format('-d-m-Y').'.xlsx';

        $ids=[];
        if ($report->object->type == 1) {
            array_push($ids,$report->object->id);
        }
        if ($report->object->type == 2) {
            $devices=Device::where('device_group_id', $report->object->id)->get();
            foreach ($devices as $device) {
                array_push($ids, $device->id);
            }
        }
        if ($report->object->type == 3) {
            $devices=Device::where('device_boundary_id', $report->object->id)->get();
            foreach ($devices as $device) {
                array_push($ids, $device->id);
            }
        }

        $dateRange = $this->getDateRangeByPeriod($report->period,$report->start_period_date, $report->end_period_date);

        $startDate = Carbon::parse($dateRange->startDate)->setTimezone('Europe/Moscow')->format('Y-m-d');
        $endDate = Carbon::parse($dateRange->endDate)->setTimezone('Europe/Moscow')->format('Y-m-d');

        $device_parameters_history = DeviceParametersHistory::with(['device', 'device.deviceBoundary:id,title'])
            ->whereBetween('created_at',  [$startDate." 00:00:00", $endDate." 23:59:59"])
            ->whereIn('device_id', $ids)
            ->get();

        $history_grouped_by_date = $this->getDeviceParametersHistoryGroupedByDate($device_parameters_history);
        $history_grouped_by_device = $this->getDeviceParametersHistoryGroupedByDevice($device_parameters_history);
        Excel::store(new ReportExport($history_grouped_by_date, $history_grouped_by_device, $report->parameter) , $report_name, 'public');
//            $url = Storage::url($report_name);

        $this->setAfter((object)$report);
        $this->saveHistory("Экспорт отчета в эксель", ModelType::Report);

        foreach ($request->recipients as $recipient) {
//              Mail::to($recipient)->send(new ReportMail($report_name));
            Mail::to($recipient['email'])->send(new ReportMail($report_name));
        }

        $this->setAfter((object)$report);
        $this->saveHistory("Отправка отчета", ModelType::Report);

    }

    public function sendAllReportsToEmails(Request $request)
    {
        $reports = Report::all();
        foreach ($reports as $report) {
            $report_name = $report->title . Carbon::now()->format('-d-m-Y') . '.xlsx';

            $ids=[];
            if ($report->object->type == 1) {
                array_push($ids,$report->object->id);
            }
            if ($report->object->type == 2) {
                $devices=Device::where('device_group_id', $report->object->id)->get();
                foreach ($devices as $device) {
                    array_push($ids, $device->id);
                }
            }
            if ($report->object->type == 3) {
                $devices=Device::where('device_boundary_id', $report->object->id)->get();
                foreach ($devices as $device) {
                    array_push($ids, $device->id);
                }
            }

            $dateRange = $this->getDateRangeByPeriod($report->period, $report->start_period_date, $report->end_period_date);

            $startDate = Carbon::parse($dateRange->startDate)->setTimezone('Europe/Moscow')->format('Y-m-d');
            $endDate = Carbon::parse($dateRange->endDate)->setTimezone('Europe/Moscow')->format('Y-m-d');

            $device_parameters_history = DeviceParametersHistory::with(['device', 'device.deviceBoundary:id,title'])
                ->whereBetween('created_at', [$startDate . " 00:00:00", $endDate . " 23:59:59"])
                ->whereIn('device_id', $ids)
                ->get();

            $history_grouped_by_date = $this->getDeviceParametersHistoryGroupedByDate($device_parameters_history);
            $history_grouped_by_device = $this->getDeviceParametersHistoryGroupedByDevice($device_parameters_history);
            Excel::store(new ReportExport($history_grouped_by_date, $history_grouped_by_device, $report->parameter), $report_name, 'public');
//            $url = Storage::url($report_name);

            $this->setAfter((object)$report);
            $this->saveHistory("Экспорт отчета в эксель", ModelType::Report);

            foreach ($request->recipients as $recipient) {
//              Mail::to($recipient)->send(new ReportMail($report_name));
                Mail::to($recipient['email'])->send(new ReportMail($report_name));
            }

            $this->setAfter((object)$report);
            $this->saveHistory("Отправка отчета", ModelType::Report);
        }
    }
    public function toggle(Request $request, Report $report)
    {
        $this->setBefore((object)$report);

        $report->is_active = $request->is_active;
        $report->save();

        $this->setAfter((object)$report);
        $this->saveHistory("Смена статуса", ModelType::Report);

        return response()
            ->json([
                'report' => $report,
                "status" => 200,
            ]);
    }

    public function toggleAll(Request $request)
    {
        $reports = Report::all();

        foreach ($reports as $report) {
            $this->setBefore((object)$report);

            $report->is_active = $request->is_active;
            $report->save();

            $this->setAfter((object)$report);
            $this->saveHistory("Смена статуса", ModelType::Report);
        }

        return response()
            ->json([
                'reports' => $reports,
                "status" => 200,
            ]);
    }
}
