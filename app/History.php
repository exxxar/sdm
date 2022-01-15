<?php

namespace App;

use App\Enums\ModelType;
use App\Models\DeviceCoordsHistory;
use App\Models\Report;
use App\Models\ReportTemplate;
use App\Models\User;
use App\Models\UserHasDeviceGroup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class History extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'object_id',
        'action',
        'object_before',
        'object_after',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'object_id' => 'integer',
        'object_before' => 'array',
        'object_after' => 'array',
        // 'type' => ModelType::class,
        'created_at' => 'timestamp:Y-m-d H:i:s',
    ];

    protected $appends = [
        'object'
    ];

    public const ACTIONS = [
        "Редактирование",
        "Создание",
        "Смена статуса",
        "Обновлены заметки",
        "Удаление",
        "Восстановление",
        "Смена типа рубежа",
        "Обновление рубежа устройства",
        "Добавление в группу",
        "Обновление группы (сброс)",
        "Логирование",
        "Сброс группы устройств",
        "Смена типа активности",
        "Удаление из расписания"
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeWithFilters($query, $filters)
    {
        return $query->when($filters->operation_type, function ($query) use ($filters) {
            $query->where('action', $filters->operation_type);
        })->when($filters->object_type_id, function ($query) use ($filters) {
            $query->where('type', $filters->object_type_id);
        })->when($filters->selected_user, function ($query) use ($filters) {
            $query->where('user_id', $filters->selected_user);
        })->when($filters->start_date, function ($query) use ($filters) {
            $query->where('created_at', '>=', Carbon::parse($filters->start_date));
        })->when($filters->end_date, function ($query) use ($filters) {
            $query->where('created_at', '<=', Carbon::parse($filters->end_date));
        })->when($filters->object_id, function ($query) use ($filters) {
            $query->where('object_id', $filters->object_id);
        });
    }

    public function getObjectAttribute()
    {
        $object = null;

        switch ($this->type) {
            default:
            case 0:

                $object['objectTitle'] = '';
                $object['typeTitle'] = '';
                $object['objectLink'] = "";

                break;
            case 1:

                $object = Boundary::whereId($this->object_id)->with(['region', 'boundaryGroup'])->first();
                $object['objectTitle'] = $object['title'] ?? '';
                $object['typeTitle'] = 'Рубеж';
                $object['objectLink'] = "/boundaries/edit/" . ($object->id ?? 0);

                break;
            case 2:

                $object = BoundaryGroup::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Группа рубежей';
                $object['objectLink'] = "/boundary-groups/edit/" . ($object->id ?? 0);

                break;
            case 3:

                $object = BoundarySchedule::whereId($this->object_id)->first();
                $object['objectTitle'] = 'Не установлено';
                $object['typeTitle'] = 'Расписание рубежей';
                $object['objectLink'] = null;


                break;
            case 4:

                $object = Device::whereId($this->object_id)->with(['region', 'group', 'deviceBoundary', 'deviceType'])->first();
                $object['objectTitle'] = '';
                if (isset($object['serial'])) {
                    $object['objectTitle'] = $object['serial'] ?? 'Не установлено';
                }
                $object['typeTitle'] = 'Устройство';
                $object['objectLink'] = "/devices/" . ($object->id ?? 0);

                break;
            case 5:

                $object = DeviceGroup::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Группа устройств';
                $object['objectLink'] = "/device-groups/" . ($object->id ?? 0);

                break;
            case 6:


                $object = DeviceParametersHistory::whereId($this->object_id)->first();
                $object['objectTitle'] ='Не установлено';
                $object['typeTitle'] = 'История параметров устройств';
                $object['objectLink'] = null;

                break;
            case 7:

                $object = DeviceCoordsHistory::whereId($this->object_id)->first();
                $object['objectTitle'] = 'Не установлено';
                $object['typeTitle'] = 'История координат устройств';
                $object['objectLink'] = null;

                break;
            case 8:

                $object = DeviceType::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Тип устройств';
                $object['objectLink'] = "/bondaries/" . ($object->id ?? 0);


                break;;
            case 9:

                $object = Dictionary::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Словарь';
                $object['objectLink'] = "/dictionaries/edit/" . ($object->id ?? 0);

                break;
            case 10:

                $object = DictionaryType::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Тип словаря';
                $object['objectLink'] = "/dictionary-types/edit/" . ($object->id ?? 0);

                break;
            case 11:

                $object = History::whereId($this->object_id)->first();
                $object['objectTitle'] = 'Не установлено';
                $object['typeTitle'] = 'История операций';
                $object['objectLink'] = null;

                break;
            case 12:

                $object = Location::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Локация';
                $object['objectLink'] = null;


                break;
            case 13:

                $object = Region::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Регион';
                $object['objectLink'] = "/region/" . ($object->id ?? 0);


                break;
            case 14:

                $object = Report::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Отчет';
                $object['objectLink'] = "/reports/" . ($object->id ?? 0);

                break;
            case 15:

                $object = ReportTemplate::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Шаблон отчета';
                $object['objectLink'] = "/report-templates/" . ($object->id ?? 0);

                break;
            case 16:
                $object = Task::whereId($this->object_id)->with(['device', 'boundary'])->first();
                $object['objectTitle'] = 'Обращение №' . ($object['id'] ?? 'Не установлено');
                $object['typeTitle'] = 'Обращение';
                $object['objectLink'] = "/task/" . ($object->id ?? 0);
                break;

            case 17:

                $object = TaskStatus::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Статус обращения';
                $object['objectLink'] = "/task-status/" . ($object->id ?? 0);


                break;
            case 18:

                $object = User::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Пользователь';
                $object['objectLink'] = "/users/" . ($object->id ?? 0);

                break;
            case 19:

                $object = UserHasDeviceGroup::whereId($this->object_id)->first();
                $object['objectTitle'] = 'Не установлено';
                $object['typeTitle'] = 'Пользовательская группа устройств';
                $object['objectLink'] = null;

                break;
            case 20:

                $object['objectTitle'] = 'Не установлено';
                $object['typeTitle'] = 'Прокси';
                $object['objectLink'] = null;

                break;
            case 21:

                $object = Role::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Роли';
                $object['objectLink'] = null;


                break;
            case 22:

                $object = Permission::whereId($this->object_id)->first();
                $object['objectTitle'] = $object['title'] ?? 'Не установлено';
                $object['typeTitle'] = 'Разрешения';
                $object['objectLink'] = null;


                break;
        }
        return $object;
    }
}
