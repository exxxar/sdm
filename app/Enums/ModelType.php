<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ModelType extends Enum
{
    const None =   0;
    const Boundary =   1;
    const BoundaryGroup =   2;
    const BoundarySchedule = 3;
    const Device = 4;
    const DeviceGroup = 5;
    const DeviceParametersHistory = 6;
    const DeviceCoordsHistory = 7;
    const DeviceType = 8;
    const Dictionary = 9;
    const DictionaryType = 10;
    const History = 11;
    const Location = 12;
    const Region = 13;
    const Report = 14;
    const ReportTemplate = 15;
    const Task = 16;
    const TaskStatus = 17;
    const User = 18;
    const UserHasDeviceGroup = 19;
    const Proxi = 20;
    const Role = 21;
    const Permission = 22;
}
