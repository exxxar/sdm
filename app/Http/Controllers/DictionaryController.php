<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\DeviceType;
use App\Dictionary;
use App\Enums\ModelType;
use App\Http\Requests\DictionaryStoreRequest;
use App\Http\Requests\DictionaryUpdateRequest;
use App\Http\Resources\DictionaryCollection;
use App\Http\Resources\DictionaryResource;
use App\Imports\DictionaryImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DictionaryController extends Controller
{
    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр справочников')->only('index','show');
        $this->middleware('permission:Добавление справочников')->only('store');
        $this->middleware('permission:Удаление справочников')->only('destroy', 'forceDelete');
        $this->middleware('permission:Изменение справочников')->only('update');
        $this->middleware('permission:Восстановление справочников')->only('restore');
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DictionaryCollection
     */
    public function index(Request $request)
    {
        $dictionaries = Dictionary::all();

        return new DictionaryCollection($dictionaries);
    }

    /**
     * @param \App\Http\Requests\DictionaryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DictionaryStoreRequest $request)
    {
        $dictionary = Dictionary::create($request->validated());

        $this->setAfter((object)$dictionary);
        $this->saveHistory("Создание", ModelType::Dictionary);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Dictionary $dictionary
     * @return \App\Http\Resources\DictionaryResource
     */
    public function show(Request $request, Dictionary $dictionary)
    {
        return new DictionaryResource($dictionary);
    }

    /**
     * @param \App\Http\Requests\DictionaryUpdateRequest $request
     * @param \App\Dictionary $dictionary
     * @return \App\Http\Resources\DictionaryResource
     */
    public function update(DictionaryUpdateRequest $request, Dictionary $dictionary)
    {
        $this->setBefore((object)Dictionary::find($dictionary->id));

        $dictionary->update($request->validated());

        $this->setAfter((object)$dictionary);
        $this->saveHistory("Редактирование", ModelType::Dictionary);

        return new DictionaryResource($dictionary);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Dictionary $dictionary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Dictionary $dictionary)
    {

        $keep_array = [1, 2, 3, 4, 5, 6, 7];

        if (in_array($dictionary->id, $keep_array))
            return response()->setStatusCode(403);

        if ($dictionary->title === "Роли")

            return response()->setStatusCode(403);

        $this->setBefore((object)$dictionary);

        $dictionary->delete();

        $this->setAfter((object)$dictionary);
        $this->saveHistory("Удаление", ModelType::Dictionary);

        return response()->noContent();
    }


    public function restore(Request $request, $id)
    {
        $dictionary = Dictionary::withTrashed()->find($id);
        $this->setBefore((object)$dictionary);

        $dictionary->restore();

        $this->setAfter((object)$dictionary);
        $this->saveHistory("Восстановление", ModelType::Dictionary);

        return response()->noContent();
    }

    public function dictionaryUpload(Request $request)
    {
        $file = $request->file('file');

        $file->getClientOriginalName();

        $file->getClientOriginalExtension();

        $file->getRealPath();

        $file->getSize();

        $file->getMimeType();

        $destinationPath = storage_path('app/public');
        $file->move($destinationPath, $file->getClientOriginalName());

        Excel::import(new DictionaryImport, storage_path('app/public/') . $file->getClientOriginalName());

        return response()->noContent();
    }
}
