<?php

namespace App\Imports;

use App\Classes\OperationHistory;
use App\Dictionary;
use App\DictionaryType;
use App\Enums\ModelType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;

class DictionaryImport implements OnEachRow
{
    use OperationHistory;

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        if ($rowIndex == 1)
            return null;


        if ($row[0] == '')
            return;

        $dictType = DictionaryType::find($row[2] );

        if (is_null($dictType))
        {
            $dicionary_type = DictionaryType::create([
                'id'=>$row[2],
                'title'=>"Новый тип словаря ".$row[2],
                'description'=>"Описание нового типа ".$row[2],
            ]);

            $this->setAfter((object)$dicionary_type);
            $this->saveHistory("Импорт из эксель файла", ModelType::DictionaryType);
        }

        $dictionary = Dictionary::create([
            'title' => $row[0] ?? 'empty',
            'description' => $row[1] ?? 'empty',
            'dictionary_type_id' => $row[2] ?? 0,
        ]);

        $this->setAfter((object)$dictionary);
        $this->saveHistory("Импорт из эксель файла", ModelType::Dictionary);
    }
}
