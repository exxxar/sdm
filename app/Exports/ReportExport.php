<?php

namespace App\Exports;

use App\Classes\Utilites;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportExport implements FromArray, WithTitle, ShouldAutoSize
{
    use Utilites;
    private $history_grouped_by_date, $history_grouped_by_device, $parameter;

    public function __construct(array $history_grouped_by_date,array $history_grouped_by_device, string $parameter)
    {
        $this->history_grouped_by_date = $history_grouped_by_date;
        $this->history_grouped_by_device = $history_grouped_by_device;
        $this->parameter = $parameter;
    }

    public function array(): array
    {
        $boundaries=(object)[];
        $records=[];
        foreach ($this->history_grouped_by_date as $item) {
            $record = (object)[];
            $record->date = $item->date;
            $boundaries->date = '';
            $index = 0;
            $devices = collect($item->devices);
            foreach ($this->history_grouped_by_device as $elem) {
                $device = $devices->firstWhere('name', $elem->name);
                $record->{$elem->name} = 0;
                if(!is_null($device))
                {
                    $boundaries->{$elem->name} = $device->boundary_title;
                    if($this->parameter=='violations'){
                        if(isset($device->violations)) {
                            $record->{$elem->name} = $device->violations;
                        }
                    }
                    if($this->parameter=='passages'){
                        if(isset($device->passages)){
                            $record->{$elem->name} = $device->passages;
                        }
                    }
                    if($this->parameter=='voltage'){
                        if(isset($device->voltage)){
                            $record->{$elem->name} = $device->voltage;
                        }
                    }
                }
                $index++;
            }

            $index = 0;
            $record->average = 0;
            $record->total = 0;
            foreach ($this->history_grouped_by_device as $elem) {
                $device = $devices->firstWhere('name', $elem->name);
                if(!is_null($device))
                {
                    $record->average += 0;
                    $record->total += 0;
                    if($this->parameter=='violations'){
                        if(isset($device->violations)) {
                            $record->average += $device->violations;
                            $record->total += $device->violations;
                        }
                    }
                    if($this->parameter=='passages'){
                        if(isset($device->passages)){
                            $record->average += $device->passages;
                            $record->total += $device->passages;
                        }
                    }
                    if($this->parameter=='voltage'){
                        if(isset($device->voltage)){
                            $record->average += $device->voltage;
                            $record->total += $device->voltage;
                        }
                    }
                }
                $index++;
            }

            $record->total = round( $record->total,2);
            $record->average = round($record->average/$index,2);
            array_push($records, $record);
        }

        $heads = ['Дата'];
        foreach ($this->history_grouped_by_device as $item) {
            array_push($heads, $item->name);
        }
        array_push($heads, 'Среднее');
        array_push($heads, 'Итого');
        array_unshift($records, $heads);

        array_unshift($records, $boundaries);
        return $records;

        /*$summary=$this->summary;
        $records =[];
        foreach ($summary as $item) {
            $r = (object)[];
            $r->date = $item->date;
            $devices = collect($item->devices);
            foreach ($this->device_titles as $elem) {
                $dev = $devices->firstWhere('name', $elem->serial);
                $r->{$elem->id} = 'нет';
                if(!is_null($dev))
                {
                    if($this->parameter=='violations'){
                        $r->{$elem->id} = $dev->violations;
                    }
                    if($this->parameter=='passages'){
                        $r->{$elem->id} = 0;
                        if(isset($dev->passages)){
                            $r->{$elem->id} = $dev->passages;
                        }

                    }
                    if($this->parameter=='voltage'){
                        $r->{$elem->id} = 0;
                        if(isset($dev->voltage)){
                            $r->{$elem->id} = $dev->voltage;
                        }
                    }
                }
            }
            array_push($records, $r);
        }

         return $records;*/
    }

//    public function headings(): array
//    {
//        $heads = ['Дата'];
//        foreach ($this->history_grouped_by_device as $item) {
//            array_push($heads, $item->name);
//        }
//        array_push($heads, 'Среднее');
//        array_push($heads, 'Итого');
//        return $heads;
//    }

    /**
     * @return string
     */
    public function title(): string
    {
        if($this->parameter=='violations'){
            return 'Нарушения';
        }
        if($this->parameter=='passages'){
            return 'Проезды';
        }
        if($this->parameter=='voltage'){
            return 'Напряжение';
        }
        return 'SDM';
    }
}
