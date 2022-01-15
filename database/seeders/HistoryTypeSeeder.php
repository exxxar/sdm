<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            "Рубеж",
            "Группа рубежей",
            "Расписание рубежей",
            "Устройство",
            "Группа устройств",
            "История параметров устройств",
            "История координат устройств",
            "Тип устройств",
            "Словарь",
            "Тип словаря",
            "История операций",
            "Локация",
            "Регион",
            "Отчет",
            "Шаблон отчета",
            "Обращение",
            "Статус обращения",
            "Пользователь",
            "Пользовательская группа устройств",
            "",
            "Роли",
            "Разрешения"
        ];

        $models = [
            "App\Boundary",
            "App\BoundaryGroup",
            "App\BoundarySchedule",
            "App\Device",
            "App\DeviceGroup",
            "App\DeviceParametersHistory",
            "App\Models\DeviceCoordsHistory",
            "App\DeviceType",
            "App\Dictionary",
            "App\DictionaryType",
            "App\History",
            "App\Location",
            "App\Region",
            "App\Models\Report",
            "App\Models\ReportTemplate",
            "App\Task",
            "App\TaskStatus",
            "App\Models\User",
            "App\Models\UserHasDeviceGroup",
            "",
            "Spatie\Permission\Models\Role",
            "Spatie\Permission\Models\Permission"
        ];

        $array_titles = [
            "boundaries",
            "boundaryGroups",
            "boundarySchedules",
            "devices",
            "deviceGroups",
            "deviceParametersHistories",
            "deviceCoordsHistories",
            "deviceTypes",
            "dictionaries",
            "dictionaryTypes",
            "histories",
            "locations",
            "regions",
            "reports",
            "reportTemplates",
            "tasks",
            "taskStatuses",
            "users",
            "userHasDeviceGroups",
            "",
            "roles",
            "permissions"
        ];

        DB::table('history_types')->truncate();

        foreach ($titles as $key => $title) {
            DB::table('history_types')->insert([
                'title' => $title,
                'model_type' => $models[$key],
                'array_title' => $array_titles[$key]
            ]);
        }
    }
}
