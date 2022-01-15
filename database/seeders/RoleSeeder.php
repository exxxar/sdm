<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Role::truncate();

        $role0 = Role::create(['name' => 'Демонстрационная']);

        foreach (Permission::all() as $permission) {
            $role0->givePermissionTo($permission->name);
            $role0->save();
        }


        $role1 = Role::create(['name' => 'Администратор']);


        foreach (Permission::all() as $permission) {
            $role1->givePermissionTo($permission->name);
            $role1->save();
        }

        $role2_permissions = [
            'Просмотр пользователей',
        ];

        $role2 = Role::create(['name' => 'Заказчик']);

        foreach ($role2_permissions as $permission) {
            if (!is_null(Permission::where("name",$permission)->first())) {
                $role2->givePermissionTo($permission);
                $role2->save();
            }
        }

        $role3_permissions = [
            'Просмотр пользователей',
            'Просмотр ролей',
            'Справочники',
            'Просмотр тип устройств',
            'Просмотр регионов',
            'Просмотр производителя устройств',
            'Просмотр SNMP ветки',
            'Просмотр ошибок',
            'Просмотр истории операций',
            'Просмотр типов нарушений',
        ];


        $role3 = Role::create(['name' => 'Исполнитель']);

        foreach ($role3_permissions as $permission) {
            if (!is_null(Permission::where("name",$permission)->first())) {
                $role3->givePermissionTo($permission);
                $role3->save();
            }
        }


    }
}
