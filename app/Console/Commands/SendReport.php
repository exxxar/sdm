<?php

namespace App\Console\Commands;

use App\Classes\Utilites;
use App\Device;
use App\Exports\ReportExport;
use App\Exports\SummaryExport;
use App\Mail\ReportMail;
use App\DeviceParametersHistory;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendReport extends Command
{

    use Utilites;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:report {regularity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reports by email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reports=Report::where('automatic', true)
            ->where('regularity', $this->argument('regularity'))
            ->where('is_active', true)
            ->where('mailing', true)->get();
        foreach ($reports as $report)
        {
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

//            $ids = $report->objects->map(function ($item, $key) {
//                return $item->id;
//            });

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
            if(count($report->recipients)){
                foreach ($report->recipients as $recipient) {
                    $user = User::find($recipient);
                    Mail::to($user->email)->send(new ReportMail($report_name));
//              Mail::to($recipient->email)->send(new ReportMail($report_name));
                }
            }

        }

        return 0;
    }
}
