<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //  User::truncate();

        $user = User::where('email', 'infinitySoul13@gmail.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Helen',
                'email' => 'infinitySoul13@gmail.com',
                'password' => '$2y$10$QZNC.yaaCXiUbUbS78ZqOe/W8vP7XGRhNAj4JXZpycwTadT.exjda',
            ]);
        }

        $user->assignRole('Демонстрационная');
        $user->save();

        $user = User::where('email', 'likholetovalex@gmail.com')->first();;

        if (!$user) {
            $user = User::create([
                'name' => 'Alexandr',
                'email' => 'likholetovalex@gmail.com',
                'password' => '$2y$10$QZNC.yaaCXiUbUbS78ZqOe/W8vP7XGRhNAj4JXZpycwTadT.exjda',
            ]);
        }
        
        $user->assignRole('Демонстрационная');
        $user->save();

        $user = User::where('email', 'imedia.penza@yandex.ru')->first();;

        if (!$user) {
            $user = User::create([
                'name' => 'Dmitry',
                'email' => 'imedia.penza@yandex.ru',
                'password' => '$2y$10$cpk8.xrErV0rKd2OgRuEu.OWyqpnjnf6Iv01gCob4R4Lb2KhTa9Ia',
            ]);
        }

        $user->assignRole('Администратор');
        $user->save();

        $user = User::where('email', 'killersssurprise@gmail.com')->first();;

        if (!$user) {
            $user = User::create([
                'name' => 'mixa',
                'email' => 'killersssurprise@gmail.com',
                'password' => bcrypt("password"),
            ]);
        }

        $user->assignRole('Исполнитель');
        $user->save();

        $user = User::where('email', 'killersssurprise@gmail.com')->first();;

        if (!$user) {
            $user = User::create([
                'name' => 'd.mochalin',
                'email' => 'd.mochalin@maksoft.ru',
                'password' => bcrypt("password"),
            ]);
        }

        $user->assignRole('Заказчик');
        $user->save();

        $user = User::where('email', 'demo@demo.com')->first();;
        if (!$user) {
            $user = User::create([
                'name' => 'demo',
                'email' => 'demo@demo.com',
                'password' => bcrypt("password"),
            ]);
        }
        $user->assignRole('Демонстрационная');
        $user->save();

    }
}
