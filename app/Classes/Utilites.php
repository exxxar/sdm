<?php


namespace App\Classes;


use App\Device;
use App\DeviceParametersHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait Utilites
{
    public function replaceDeviceWithBoundariesChart(array $charts): array
    {
        $temporary_charts = [];

        foreach ($charts as $chart) {
            $temporary_chart = [];
            $temporary_chart['name'] = $chart->dates[0]->boundary_title;
            $temporary_chart['dates'] = $chart->dates;

            $neededObjects = array_filter(
                $temporary_charts,
                function ($e) use ($temporary_chart) {
                    return $e->name == $temporary_chart['name'];
                }
            );

            if (empty($neededObjects)) {
                foreach ($temporary_chart['dates'] as $key => $date) {
                    $date->voltage = 100;
                }

                array_push($temporary_charts, (object)$temporary_chart);
            } else {
                foreach ($neededObjects as $key => $neededObject) {
                    foreach ($temporary_charts[$key]->dates as $key => $date) {
                        $date->passages += $temporary_chart['dates'][$key]->passages;
                        $date->violations += $temporary_chart['dates'][$key]->violations;
                        $date->voltage = 100;
                    }
                }
            }
        }

        return $temporary_charts;
    }

    public function replaceDeviceWithBoundariesTable(array $records): array
    {
        $temporary_records = [];

        foreach ($records as $record) {
            $temporary_record = [];
            $temporary_record['date'] = $record->date;
            $temporary_record['average'] = $record->average;
            $temporary_record['average']->voltage = 100;
            $temporary_record['total'] = $record->total;

            foreach ($record as $key => $value) {
                if (!is_object($value)) {
                    continue;
                }

                if (!property_exists($value, 'boundary_title')) {
                    continue;
                }

                if (!array_key_exists($value->boundary_title, $temporary_record)) {
                    $temporary_record[$value->boundary_title] = $value;
                    $temporary_record[$value->boundary_title]->voltage = 100;
                } else {
                    $temporary_record[$value->boundary_title]->passages += $value->passages;
                    $temporary_record[$value->boundary_title]->violations += $value->violations;
                }
            }
            array_push($temporary_records, $temporary_record);
        }
        return $temporary_records;
    }

    public function getDeviceParametersHistoryGroupedByDevice($device_parameters_history)
    {

        $history_grouped_by_device = $device_parameters_history->sortBy('device_id')->groupBy('device.serial');

        //dd($device_parameters_history->toArray());
        $summary = [];
        foreach ($history_grouped_by_device as $device_name => $history_in_device) {
            $record_in_summary = (object)[];
            $record_in_summary->name = $device_name;
            $record_in_summary->dates = [];
            $history_in_device_grouped_by_date = $history_in_device->sortBy('created_at')->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d.m.Y');
            });
            foreach ($history_in_device_grouped_by_date as $date => $history_in_date) {
                $device = (object)[];
                $device->id = $history_in_date[0]->id;
                $device->device_id = $history_in_device[0]->device_id;
                $device->boundary_title = '';
                if (!is_null($history_in_date[0]->device->deviceBoundary) || isset($history_in_date[0]->device->deviceBoundary)) {
                    $device->boundary_title = $history_in_date[0]->device->deviceBoundary->title;
                }
                $device->boundary_id = $history_in_date[0]->device->device_boundary_id;
                $device->date = $history_in_date[0]->created_at;
                $device->date_title = $date;


                $dd = Device::find($history_in_device[0]->device_id);

                $device->device_type_id = $dd->device_type_id;

                if ($device->device_type_id == 3) {
                    $device->passages = $history_in_date->sum('passages');
                    $device->violations = $history_in_date->sum('violations');
                } else {
                    $device->passages = $history_in_date->max('passages');
                    $device->violations = $history_in_date->max('violations');
                }

                $device->ping = $history_in_date->max('ping');
//                $device->voltage = round($history_in_date->where('voltage', '!=', -1)->sum('voltage'),2);
                $device->voltage = 0;


                $index = 0;
                foreach ($history_in_date as $item) {
                    if (!is_null($item->voltage) || isset($item->voltage)) {
                        if ($item->voltage == -1) {
                            $device->voltage += 0;
                        }
                        if ($item->voltage >= 12) {
                            $device->voltage += 100;
                        }
                        if ($item->voltage > -1 && $item->voltage < 12) {
                            $percent = round(($item->voltage / 12) * 100, 2);
                            $device->voltage += $percent;
                        }
                        $index++;
                    }
                }
                $device->voltage = round(($device->voltage / (100 * $index) * 100), 2);

                array_push($record_in_summary->dates, $device);
            }
            array_push($summary, $record_in_summary);
        }

      /*  $summary = collect($summary)->sortBy(function ($data){
            return $data->dates[0]->device_type_id;
        })->reverse()->toArray();*/
        return $summary;
    }

    public function getDeviceParametersHistoryGroupedByDate($device_parameters_history)
    {
        $history_grouped_by_day = $device_parameters_history->sortBy('created_at')->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('d.m.Y');
        });
        $summary = [];
        foreach ($history_grouped_by_day as $date => $history_in_date) {
            $record_in_summary = (object)[];
            $record_in_summary->date = $date;
            $record_in_summary->devices = [];

            $history_in_date_grouped_by_device = $history_in_date->sortBy('device.id')->groupBy('device.serial');



            foreach ($history_in_date_grouped_by_device as $device_name => $history_in_device) {


                $device = (object)[];
                $device->id = $history_in_device[0]->id;
                $device->device_id = $history_in_device[0]->device_id;


                $device->name = $device_name;
                $device->boundary_title = '';
                if (!is_null($history_in_device[0]->device->deviceBoundary) || isset($history_in_device[0]->device->deviceBoundary)) {
                    $device->boundary_title = $history_in_device[0]->device->deviceBoundary->title;
                }
                $device->boundary_id = $history_in_device[0]->device->device_boundary_id;;

                $device->device_type_id = $history_in_device[0]->device->device_type_id;

                if ($device->device_type_id == 3) {
                    $device->passages = $history_in_device->sum('passages');

                    $device->violations = $history_in_device->sum('violations');
                } else {
                    $device->passages = $history_in_device->max('passages');

                    $device->violations = $history_in_device->max('violations');
                }


                $device->ping = $history_in_device->max('ping');
//              $device->voltage = round($history_in_device->where('voltage', '!=', -1)->sum('voltage'),2);
                $device->voltage = 0;
                $index = 0;
                foreach ($history_in_device as $item) {
                    if (!is_null($item->voltage) || isset($item->voltage)) {
                        if ($item->voltage == -1) {
                            $device->voltage += 0;
                        }
                        if ($item->voltage >= 12) {
                            $device->voltage += 100;
                        }
                        if ($item->voltage > -1 && $item->voltage < 12) {
                            $percent = round(($item->voltage / 12) * 100, 2);
                            $device->voltage += $percent;
                        }
                        $index++;
                    }
                }
                $device->voltage = round(($device->voltage / (100 * $index) * 100), 2);

                array_push($record_in_summary->devices, $device);
            }
            array_push($summary, $record_in_summary);
        }

        return $summary;
    }

    public function getDateRangeByPeriod($period, $start_period_date = null, $end_period_date = null)
    {  

        if ($period == 'date-range') {
            $year = Carbon::now()->year;
            $year_of_startDate = Carbon::parse($start_period_date)->year;
            $year_of_endDate = Carbon::parse($end_period_date)->year;
            $difference_with_startDate = $year - $year_of_startDate;
            $difference_with_endDate = $year - $year_of_endDate;
            $startDate = Carbon::parse($start_period_date);//->addYears($difference_with_startDate);
            $endDate = Carbon::parse($end_period_date);//->addYears($difference_with_endDate);
        } else {
            $tmp = [
                "day" => 1,
                "week" => Carbon::now()->setTimezone('Europe/Moscow')->dayOfWeek,
                "month" => Carbon::now()->setTimezone('Europe/Moscow')->day,
                "year" => Carbon::now()->setTimezone('Europe/Moscow')->dayOfYear
            ];

            if ($period == "day") {
                $startDate = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay();
                $endDate = $startDate->copy()->setTimezone('Europe/Moscow')->endOfDay();
            } else {
                $startDate = Carbon::now()->setTimezone('Europe/Moscow')->subDays($tmp[$period] - 1);
                $endDate = Carbon::now()->setTimezone('Europe/Moscow');
            }
        }

        $range = (object)[];
        $range->startDate = $startDate;
        $range->endDate = $endDate;

        return $range;
    }

    public function getSummaryRecords($history_grouped_by_date, $history_grouped_by_device)
    {
        $records = [];

      /*  $history_grouped_by_date = collect($history_grouped_by_date)->sortBy(function ($data){
            dd($data);
        })
            ->reverse()->toArray();*/

        foreach ($history_grouped_by_date as $item) {

            $record = (object)[];
            $record->date = $item->date;

            //Среднее
            //Average
            $record->average = (object)[];
            $record->average->passages = 0;
            $record->average->violations = 0;
            $record->average->voltage = 0;

            //Итог
            //Total
            $record->total = (object)[];
            $record->total->passages = 0;
            $record->total->violations = 0;
            //todo: change calculating of total for voltage, maybe it will be percentage
            $record->total->voltage = 0;
            $index = 0;
            $devices = collect($item->devices);

            foreach ($history_grouped_by_device as $elem) {
                $device = $devices->firstWhere('name', $elem->name);
                $record->{$elem->name} = 0;
                if (!is_null($device)) {
                    //Свойство объекта Название устройства = запись из истории параметров устройства за эту дату
                    //Property of object is device's serial = record from device_parameters_history for this date
                    $record->{$elem->name} = $device;

                    $record->average->passages += $device->passages;
                    $record->average->violations += $device->violations;
                    $record->average->voltage += $device->voltage;

                    $record->total->passages += $device->passages;
                    $record->total->violations += $device->violations;
                    $record->total->voltage += $device->voltage;
                }
                $index++;
            }
            $record->total->passages = round($record->total->passages, 2);
            $record->total->violations = round($record->total->violations, 2);
            $record->total->voltage = round($record->total->voltage, 2);
            $record->average->passages = round($record->average->passages / $index, 2);
            $record->average->violations = round($record->average->violations / $index, 2);
            $record->average->voltage = round($record->average->voltage / $index, 2);
            array_push($records, $record);
        }

        return $records;
    }

    public function getPassagesMonth($device)
    {


        if ($device->device_type_id == 3) {
            $sum = 0;
            for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {

                $passages = DeviceParametersHistory::where("device_id", $device->id)
                        ->whereBetween("created_at", [
                            Carbon::now()->startOfMonth()->day($i)->hour(0)->minute(0)->second(0),
                            Carbon::now()->startOfMonth()->day($i)->hour(23)->minute(59)->second(59)
                        ])
                        ->sum('passages') ?? 0;

                $sum += $passages;
            }

            return $sum;
        } else {
            $sum = 0;
            for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {

                $passages = DeviceParametersHistory::where("device_id", $device->id)
                        ->whereBetween("created_at", [
                            Carbon::now()->startOfMonth()->day($i)->hour(0)->minute(0)->second(0),
                            Carbon::now()->startOfMonth()->day($i)->hour(23)->minute(59)->second(59)
                        ])
                        ->max('passages') ?? 0;

                $sum += $passages;
            }

            return $sum;
        }
    }

    public function getViolationsMonth($device)
    {


        if ($device->device_type_id == 3) {
            $sum = 0;
            for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {

                $passages = DeviceParametersHistory::where("device_id", $device->id)
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

                $passages = DeviceParametersHistory::where("device_id", $device->id)
                        ->whereBetween("created_at", [
                            Carbon::now()->startOfMonth()->day($i)->hour(0)->minute(0)->second(0),
                            Carbon::now()->startOfMonth()->day($i)->hour(23)->minute(59)->second(59)
                        ])
                        ->max('violations') ?? 0;

                $sum += $passages;
            }

            return $sum;
        }
    }

}
