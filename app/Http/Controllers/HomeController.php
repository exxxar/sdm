<?php

namespace App\Http\Controllers;

use App\BoundaryGroup;
use App\Classes\OperationHistory;
use App\Classes\Utilites;
use App\Device;
use App\DictionaryType;
use App\History;
use App\Models\Report;
use App\Models\ReportTemplate;
use App\Task;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use App\DeviceGroup;
use App\Boundary;
use App\DeviceType;
use App\Region;
use App\Dictionary;
use App\Models\User;
use App\Services\DeviceCacheService;
use App\Services\HistoryObjectsService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    use Utilites, OperationHistory;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        /*   $this->middleware('permission:Просмотр справочников')->only('');*/
        $this->middleware('permission:Добавление справочников')->only('dictionariesAdd');
        $this->middleware('permission:Изменение справочников')->only('dictionariesEdit');

        $this->middleware('permission:Просмотр пользователей')->only('users', 'usersShow');
        $this->middleware('permission:Добавление пользователей')->only('usersAdd');
        $this->middleware('permission:Изменение пользователей')->only('usersEdit');

        /*        $this->middleware('permission:Просмотр ролей')->only('');*/

        $this->middleware('permission:Просмотр устройств')->only('devices', 'devicesShow');
        $this->middleware('permission:Добавление устройств')->only('devicesAdd');
        $this->middleware('permission:Изменение устройств')->only('devicesEdit');

        $this->middleware('permission:Просмотр групп устройств')->only('deviceGroups', 'deviceGroupsShow');
        $this->middleware('permission:Добавление групп устройств')->only('deviceGroupsAdd');
        $this->middleware('permission:Изменение групп устройств')->only('deviceGroupsEdit');


        /*      $this->middleware('permission:Просмотр тип устройств')->only('');

              $this->middleware('permission:Просмотр истории')->only('');

              $this->middleware('permission:Просмотр регионов')->only('');*/

        $this->middleware('permission:Просмотр производителя устройств')->only('');

        $this->middleware('permission:Просмотр рубежа')->only('boundaries', 'boundariesShow');
        $this->middleware('permission:Добавление рубежа')->only('boundariesAdd');
        $this->middleware('permission:Изменение рубежа')->only('boundariesEdit');

        $this->middleware('permission:Просмотр группы рубежей')->only('boundaryGroups');
        $this->middleware('permission:Добавление группы рубежей')->only('boundaryGroupsAdd');
        $this->middleware('permission:Изменение группы рубежей')->only('boundaryGroupsEdit');

        $this->middleware('permission:Просмотр расписания рубежей')->only('boundariesSchedule');

        /*    $this->middleware('permission:Просмотр ошибок')->only('');

            $this->middleware('permission:Просмотр обращений')->only('');*/

        $this->middleware('permission:Просмотр отчетов')->only('reports', 'reportsShow');
        $this->middleware('permission:Добавление отчетов')->only('reportsAdd');
        $this->middleware('permission:Изменение отчетов')->only('reportsEdit');

        $this->middleware('permission:Просмотр шаблонов отчетов')->only('reportTemplates', 'reportsShow');
        $this->middleware('permission:Добавление шаблонов отчетов')->only('reportTemplatesAdd');
        $this->middleware('permission:Изменение шаблонов отчетов')->only('reportTemplatesEdit');

        $this->middleware('permission:Просмотр истории операций')->only('history');

        $this->middleware('permission:Просмотр системной информации')->only('systemInfo');
        $this->middleware('permission:Загрузка файлов-шаблонов')->only('getTemplate');

        $this->middleware('permission:Просмотр карты')->only('map');
        $this->middleware('permission:Просмотр сводки')->only('summary');

        $this->middleware('permission:Добавление обращений')->only('tasksAdd');
        $this->middleware('permission:Изменение обращений')->only('tasksEdit');
        $this->middleware('permission:Просмотр обращений')->only('tasksShow');
        $this->middleware('permission:Просмотр истории обращений')->only('tasksHistory');

        $this->middleware('permission:Просмотр тип справочников')->only('dictionaryTypes');
        $this->middleware('permission:Добавление тип справочников')->only('dictionaryTypesAdd');
        $this->middleware('permission:Изменение тип справочников')->only('dictionaryTypesEdit');
    }

    public function index()
    {
        $malfunctions = Dictionary::where('dictionary_type_id', 2)->get();
        return view('home', compact('malfunctions'));
    }

    public function tasksAdd()
    {
        $users = User::all();
        $boundaries = Boundary::with(["devices", "boundary_group"])->get();

        $devices = Device::withTrashed()->get();
        $malfunctions = Dictionary::where('dictionary_type_id', 2)->get();
        return view('tasks.add', compact('users', 'boundaries', 'devices', 'malfunctions'));
    }

    public function tasksEdit(Task $task)
    {
        $task = Task::with(["report"])->where("id", $task->id)->first();
        $users = User::all();
        $boundaries = Boundary::with(["devices", "boundary_group"])->get();
        $devices = Device::withTrashed()->get();
        $malfunctions = Dictionary::where('dictionary_type_id', 2)->get();
        return view('tasks.edit', compact('users', 'boundaries', 'devices', 'malfunctions', 'task'));
    }

    public function tasksShow(Task $task)
    {
        $task = Task::with(["report"])->where("id", $task->id)->first();
        $users = User::all();
        $responsible = User::whereId($task->responsible_id)->first();
        $boundary = Boundary::with(["boundary_group"])->whereId($task->boundary_id)->first();
        $devices = Device::withTrashed()->get();
        $device = Device::whereId($task->device_id)->first();
        $malfunctions = Dictionary::where('dictionary_type_id', 2)->get();
        $malfunction = Dictionary::where('dictionary_type_id', 2)->whereId($task->malfunction_id)->first();
        return view('tasks.show', compact('users', 'responsible', 'boundary', 'devices', 'malfunctions', 'device', 'malfunction', 'task'));
    }

    public function tasksHistory()
    {
        $users = User::all();
        $boundaries = Boundary::with(["boundary_group"])->get();
        $devices = Device::withTrashed()->get();
        $malfunctions = Dictionary::where('dictionary_type_id', 2)->get();
        //$appeals = Task::with(['boundary', 'device', 'malfunction'])->get();
        return view('tasks.history', compact('users', 'boundaries', 'devices', 'malfunctions'));
    }

    public function devices()
    {
        $device_groups = DeviceGroup::withTrashed()->get();
        $device_types = DeviceType::all();
        return view('devices.index', compact('device_groups', 'device_types'));
    }

    public function devicesAdd()
    {
        $device_groups = DeviceGroup::withTrashed()->get();
        $boundaries = Boundary::with(["boundary_group"])->get();
        $device_types = DeviceType::all();
        $regions = Region::all();
        return view('devices.add', compact('device_groups', 'boundaries', 'device_types', 'regions'));
    }

    public function devicesEdit(Device $device)
    {
        $device_groups = DeviceGroup::withTrashed()->get();
        $boundaries = Boundary::with(["boundary_group"])->get();
        $device_types = DeviceType::all();
        $regions = Region::all();
        $edit = 1;

        $passagesMonth = $this->getPassagesMonth($device);
        $violationsMonth = $this->getViolationsMonth($device);

        $device->device_coords_history = $device->deviceCoordsHistory()->get();
        return view('devices.edit', compact(
            'device_groups', 'boundaries', 'device_types', 'regions', 'device', 'edit',
            'violationsMonth', 'passagesMonth'
        ));
    }

    public function devicesShow(Device $device)
    {
        $device_groups = DeviceGroup::withTrashed()->get();
        $boundaries = Boundary::with(["boundary_group"])->get();
        $device_types = DeviceType::all();
        $regions = Region::all();
        $edit = 0;


        $passagesMonth = $this->getPassagesMonth($device);
        $violationsMonth = $this->getViolationsMonth($device);

        $device->device_coords_history = $device->deviceCoordsHistory()->get();


        return view('devices.edit',
            compact('device_groups', 'boundaries', 'device_types', 'regions', 'device', 'edit',
                'violationsMonth', 'passagesMonth'
            ));
    }

    public function deviceGroups()
    {
        return view('device-groups.index');
    }

    public function deviceGroupsAdd()
    {
        $devices = Device::withTrashed()->get();
        return view('device-groups.add', compact('devices'));
    }

    public function deviceGroupsEdit(DeviceGroup $deviceGroup)
    {
        $devices = Device::withTrashed()->get();
        return view('device-groups.edit', compact('devices', 'deviceGroup'));
    }

    public function deviceGroupsShow(DeviceGroup $deviceGroup)
    {
        $device_groups = DeviceGroup::withTrashed()->get();
        $device_types = DeviceType::all();
        return view('device-groups.show', compact('device_groups', 'device_types', 'deviceGroup'));
    }

    public function boundaries()
    {
        $boundaries_groups = BoundaryGroup::all();
        return view('boundaries.index', compact('boundaries_groups'));
    }

    public function boundariesAdd()
    {
        $boundary_groups = BoundaryGroup::all();
        $regions = Region::all();
        $devices = Device::withTrashed()->get();
        $violations = Dictionary::where('dictionary_type_id', 1)->get();
        return view('boundaries.add', compact('regions', 'boundary_groups', 'devices', 'violations'));
    }

    public function boundariesEdit(Boundary $boundary)
    {
        $boundary_groups = BoundaryGroup::all();
        $regions = Region::all();
        $devices = Device::withTrashed()->get();
        $violations = Dictionary::where('dictionary_type_id', 1)->get();
        $current_devices = $boundary->devices;
        $edit = 1;
        $current_violations = $boundary->dictionaries;
        return view('boundaries.edit', compact('regions', 'boundary_groups', 'devices', 'violations', 'boundary', 'current_devices', 'current_violations', 'edit'));
    }

    public function boundariesShow(Boundary $boundary)
    {
        $boundary_groups = BoundaryGroup::all();
        $regions = Region::all();
        $devices = Device::withTrashed()->get();
        $violations = Dictionary::where('dictionary_type_id', 1)->get();
        $current_devices = $boundary->devices;
        $edit = 0;
        $current_violations = $boundary->dictionaries;
        return view('boundaries.edit', compact('regions', 'boundary_groups', 'devices', 'violations', 'boundary', 'current_devices', 'current_violations', 'edit'));
    }


    public function boundariesSchedule()
    {
        $boundary_groups = BoundaryGroup::all();
        $boundaries = Boundary::with(['devices', "boundary_group"])->get();
        $devices = Device::withTrashed()->get();

        return view('boundaries.schedule', compact('boundary_groups', 'devices', 'boundaries'));
    }

    public function boundaryGroups()
    {
        return view('boundary-groups.index');
    }

    public function boundaryGroupsAdd()
    {
        $boundaries = Boundary::with(["boundary_group"])->get();
        return view('boundary-groups.add', compact('boundaries'));
    }

    public function boundaryGroupsEdit(BoundaryGroup $boundaryGroup)
    {
        $boundaries = Boundary::with(["boundary_group"])->get();
        return view('boundary-groups.edit', compact('boundaries', 'boundaryGroup'));
    }

    public function map()
    {
        //ini_set('max_execution_time', '36000');
        //$devices = Device::with(['appeals', 'deviceBoundary', 'deviceCoordsHistory', 'deviceParametersHistory'])->get();
        //file_put_contents(storage_path('data/devices.json'), json_encode($devices));
        ///$devices = DeviceCacheService::getCachedDevices();//file_get_contents(storage_path('data/devices.json'));
        //dd($devices);

        $devices = Device::with(['appeals', 'deviceBoundary', 'deviceCoordsHistory'])->get();


        $regions = Region::all();

        //$devices = Device::with(['appeals', 'deviceBoundary', 'deviceCoordsHistory'])->get();
        $device_types = DeviceType::all();
        $malfunctions = Dictionary::where('dictionary_type_id', 2)->get();
        return view('map.index', compact('regions', 'devices', 'device_types', 'malfunctions'));
    }

    public function loadHistorical(Device $device)
    {
        $violations = $this->getViolationsMonth($device);
        $passages = $this->getPassagesMonth($device);

        return response()->json([
            "violations" => $violations,
            "passages" => $passages,
        ]);
    }

    public function summary()
    {
        $devices = Device::with(['appeals', 'deviceBoundary'])
            // ->groupBy('device_type_id', 'id')
            ->orderBy("device_type_id", "ASC")
            ->get();


        $device_types = DeviceType::all();
        $device_groups = DeviceGroup::all();
        $boundaries = Boundary::all();
        return view('summary.index', compact('devices', 'device_types', 'boundaries', 'device_groups'));
    }

    public function history()
    {
        $users = User::all();
        //$history = History::with(['user'])->get();
        $objects = HistoryObjectsService::getHistoryObjects();
        $actions = History::ACTIONS;
        /*$devices = Device::all();
        foreach ($devices as $key => $device) {
            $item = (object)[];
            $item->title = $device['serial'];
            $item->id = $device['id'];
            $item->type = 4;
            array_push($objects, $item);
        }
        $boundaries = Boundary::with(["boundary_group"])->get();
        foreach ($boundaries as $key => $boundary) {
            $item = (object)[];
            $item->title = $boundary['title'];
            $item->id = $boundary['id'];
            $item->type = 1;
            array_push($objects, $item);
        }
        $appeals = Task::all();
        foreach ($appeals as $key => $appeal) {
            $item = (object)[];
            $item->title = $appeal['id'];
            $item->id = $appeal['id'];
            $item->type = 16;
            array_push($objects, $item);
        }*/
        return view('history.index', compact('users', 'objects', 'actions'));
    }

    public function users()
    {
        $users = User::with(['roles', 'device_groups'])->withTrashed()->get();

        $device_groups = DeviceGroup::withTrashed()->get();
        return view('users.index', compact('users', 'device_groups'));
    }

    public function usersAdd()
    {
        $device_groups = DeviceGroup::withTrashed()->get();
        $roles = Role::all();
        return view('users.add', compact('device_groups', 'roles'));
    }

    public function usersEdit($id)
    {
        $selected_user = User::with(['roles', 'device_groups'])->whereId($id)->first();
        $device_groups = DeviceGroup::withTrashed()->get();
        //$history = History::where('user_id', $selected_user->id)->get();
        //$devices = Device::with(['appeals', 'deviceBoundary'])->get();
        //$device_types = DeviceType::all();
        $edit = 1;
        //$roles = Role::all();
        return view('users.edit', compact('device_groups', 'selected_user', 'edit'));
    }

    public function usersShow(Request $request, $id)
    {
        //Странные махинации
        $selected_user = User::find($id)->with(['roles', 'device_groups'])->whereId($id)->first();;
        $device_groups = DeviceGroup::withTrashed()->get();
        //$history = History::where('user_id', $selected_user->id)->get();
        //$devices = Device::with(['appeals', 'deviceBoundary'])->get();
        //$device_types = DeviceType::all();
        $edit = 0;
        //$roles = Role::all();
        return view('users.edit', compact('device_groups', 'selected_user', 'edit'));
    }

    public function dictionaryTypes()
    {
        $dictionary_types = DictionaryType::all();
        $dictionaries = Dictionary::withTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('dictionary-types.index', compact('dictionary_types', 'dictionaries'));
    }

    public function dictionaryTypesAdd()
    {
        return view('dictionary-types.add');
    }

    public function dictionaryTypesEdit(DictionaryType $dictionary_type)
    {
        return view('dictionary-types.edit', compact('dictionary_type'));
    }

    public function dictionariesAdd(DictionaryType $dictionary_type)
    {
        $dictionary_type_title = $dictionary_type->title;
        $dictionary_type_id = $dictionary_type->id;
        Log::info($dictionary_type_id);
        return view('dictionaries.add', compact('dictionary_type_title', 'dictionary_type_id'));
    }

    public function dictionariesEdit(Dictionary $dictionary)
    {
        $dictionary_type = DictionaryType::whereId($dictionary->dictionary_type_id)->first();
        $dictionary_type_title = $dictionary_type->title;
        return view('dictionaries.edit', compact('dictionary', 'dictionary_type_title', 'dictionary_type'));
    }

    public function reports()
    {
        $users = User::all();
        $reports = Report::all();
        return view('reports.index', compact('reports', 'users'));
    }

    public function reportsAdd()
    {
        $objects = [];
        $devices = Device::all();
        foreach ($devices as $key => $device) {
            $item = (object)[];
            $item->id = $device['id'];
            $item->title = $device['serial'];
            $item->type = 1;
            array_push($objects, $item);
        }
        $device_groups = DeviceGroup::all();
        foreach ($device_groups as $key => $device_group) {
            $item = (object)[];
            $item->id = $device_group['id'];
            $item->title = $device_group['title'];
            $item->type = 2;
            array_push($objects, $item);
        }
        $boundaries = Boundary::with("boundary_group")->get();
        foreach ($boundaries as $key => $boundary) {
            $item = (object)[];
            $item->id = $boundary['id'];
            $item->title = $boundary['title'];
            $item->type = 3;
            array_push($objects, $item);
        }
        $boundaries_groups = BoundaryGroup::all();
        foreach ($boundaries_groups as $key => $boundaries_groups) {
            $item = (object)[];
            $item->id = $boundaries_groups['id'];
            $item->title = $boundaries_groups['title'];
            $item->type = 4;
            array_push($objects, $item);
        }

        $users = User::with(['roles'])->get();
        $roles = Role::all();
        $report_templates = ReportTemplate::all();
        return view('reports.add', compact('objects', 'users', 'roles', 'report_templates'));
    }

    public function reportsEdit(Report $report)
    {
        $objects = [];
        $devices = Device::all();
        foreach ($devices as $key => $device) {
            $item = (object)[];
            $item->id = $device['id'];
            $item->title = $device['serial'];
            $item->type = 1;
            array_push($objects, $item);
        }
        $device_groups = DeviceGroup::all();
        foreach ($device_groups as $key => $device_group) {
            $item = (object)[];
            $item->id = $device_group['id'];
            $item->title = $device_group['title'];
            $item->type = 2;
            array_push($objects, $item);
        }
        $boundaries = Boundary::with("boundary_group")->get();
        foreach ($boundaries as $key => $boundary) {
            $item = (object)[];
            $item->id = $boundary['id'];
            $item->title = $boundary['title'];
            $item->type = 3;
            array_push($objects, $item);
        }
        $boundaries_groups = BoundaryGroup::all();
        foreach ($boundaries_groups as $key => $boundaries_groups) {
            $item = (object)[];
            $item->id = $boundaries_groups['id'];
            $item->title = $boundaries_groups['title'];
            $item->type = 4;
            array_push($objects, $item);
        }
        $users = User::with(['roles'])->get();
        $roles = Role::all();
        $report_templates = ReportTemplate::all();
        return view('reports.edit', compact('report', 'objects', 'users', 'roles', 'report_templates'));
    }

    public function reportsShow(Report $report)
    {
        return view('reports.show', compact('report'));
    }

    public function reportsAutomatic()
    {
        $automatic_reports = Report::where('automatic', true)->get();
        $users = User::all();
        return view('reports.automatic', compact('automatic_reports', 'users'));
    }

    public function reportTemplates()
    {
        $report_templates = ReportTemplate::all();
        return view('report-templates.index', compact('report_templates'));
    }

    public function reportTemplatesAdd()
    {
        $objects = [];
        $devices = Device::all();
        foreach ($devices as $key => $device) {
            $item = (object)[];
            $item->id = $device['id'];
            $item->title = $device['serial'];
            $item->type = 1;
            array_push($objects, $item);
        }
        $device_groups = DeviceGroup::all();
        foreach ($device_groups as $key => $device_group) {
            $item = (object)[];
            $item->id = $device_group['id'];
            $item->title = $device_group['title'];
            $item->type = 2;
            array_push($objects, $item);
        }
        $boundaries = Boundary::with("boundary_group")->get();
        foreach ($boundaries as $key => $boundary) {
            $item = (object)[];
            $item->id = $boundary['id'];
            $item->title = $boundary['title'];
            $item->type = 3;
            array_push($objects, $item);
        }
        $users = User::all();
        $roles = Role::all();
        return view('report-templates.add', compact('objects', 'users', 'roles'));
    }

    public function reportTemplatesEdit(ReportTemplate $report_template)
    {
        $objects = [];
        $devices = Device::all();
        foreach ($devices as $key => $device) {
            $item = (object)[];
            $item->id = $device['id'];
            $item->title = $device['serial'];
            $item->type = 1;
            array_push($objects, $item);
        }
        $device_groups = DeviceGroup::all();
        foreach ($device_groups as $key => $device_group) {
            $item = (object)[];
            $item->id = $device_group['id'];
            $item->title = $device_group['title'];
            $item->type = 2;
            array_push($objects, $item);
        }
        $boundaries = Boundary::with("boundary_group")->get();
        foreach ($boundaries as $key => $boundary) {
            $item = (object)[];
            $item->id = $boundary['id'];
            $item->title = $boundary['title'];
            $item->type = 3;
            array_push($objects, $item);
        }
        $users = User::all();
        $roles = Role::all();
        return view('report-templates.edit', compact('report_template', 'objects', 'users', 'roles'));
    }

    public function reportTemplatesShow(ReportTemplate $report_template)
    {
        return view('report-templates.show', compact('report_template'));
    }

    public function systemInfo()
    {
        return view('system-info');
    }

    public function getTemplate($template)
    {

        if (!Storage::disk('public')->exists("templates\\$template.xlsx"))
            return \response()->json([
                "message" => "Шаблон не найден"
            ]);

        $file = Storage::disk('public')->get("templates\\$template.xlsx");


        return (new Response($file, 200))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=template.xlsx");


    }
}
