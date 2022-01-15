<?php

namespace Database\Seeders;

use App\Dictionary;
use App\DictionaryType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //DictionaryType::truncted();

        $dictionaries = [
            [
                "id"=>1,
                "title"=>"Нарушения"
            ],

            [
                "id"=>2,
                "title"=>"Неисправности"
            ],

            [
                "id"=>3,
                "title"=>"Системное"
            ],
        ];

        foreach ($dictionaries as $dictionary)
        {
            if (is_null(DictionaryType::where("id")->first())) {
                DictionaryType::create([
                    'id' => ((object)$dictionary)->id,
                    'title' => ((object)$dictionary)->title,
                    'description' => "",
                ]);
            }
        }

        //Dictionary::factory()->count(5)->create();
        Dictionary::create([
            'title' => 'Превышение скорости',
            'description' => null,
            'dictionary_type_id' => 1,
        ]);

        Dictionary::create([
            'title' => 'Стоп-линия',
            'description' => null,
            'dictionary_type_id' => 1,
        ]);

        Dictionary::create([
            'title' => 'Низкий заряд аккумулятора',
            'description' => null,
            'dictionary_type_id' => 2,
        ]);

        Dictionary::create([
            'title' => 'Нет ответа от камеры',
            'description' => null,
            'dictionary_type_id' => 2,
        ]);

        Dictionary::create([
            'title' => 'Камера загрязнена',
            'description' => null,
            'dictionary_type_id' => 2,
        ]);

        Dictionary::create([
            'title' => 'Другое',
            'description' => null,
            'dictionary_type_id' => 2,
        ]);

        Dictionary::create([
            'title' => 'Роли',
            'description' => null,
            'dictionary_type_id' => 3,
        ]);
    }
}
