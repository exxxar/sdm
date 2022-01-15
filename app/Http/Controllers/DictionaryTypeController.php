<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Dictionary;
use App\DictionaryType;
use App\Enums\ModelType;
use App\Http\Requests\DictionaryTypeStoreRequest;
use App\Http\Requests\DictionaryTypeUpdateRequest;
use App\Http\Resources\DictionaryTypeCollection;
use App\Http\Resources\DictionaryTypeResource;
use Illuminate\Http\Request;

class DictionaryTypeController extends Controller
{

    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Справочники');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\DictionaryTypeCollection
     */
    public function index(Request $request)
    {
        $dictionary_types = DictionaryType::all();

        return new DictionaryTypeCollection($dictionary_types);
    }

    /**
     * @param \App\Http\Requests\DictionaryTypeStoreRequest $request
     * @return \App\Http\Resources\DictionaryTypeResource
     */
    public function store(DictionaryTypeStoreRequest $request)
    {
        $dictionary_type = DictionaryType::create($request->validated());

        $this->setAfter((object)$dictionary_type);
        $this->saveHistory("Создание", ModelType::DictionaryType);

        return new DictionaryTypeResource($dictionary_type);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DictionaryType $dictionary_type
     * @return \App\Http\Resources\DictionaryTypeResource
     */
    public function show(Request $request, DictionaryType $dictionary_type)
    {
        return new DictionaryTypeResource($dictionary_type);
    }

    /**
     * @param \App\Http\Requests\DictionaryTypeUpdateRequest $request
     * @param \App\DictionaryType $dictionary_type
     * @return \App\Http\Resources\DictionaryTypeResource
     */
    public function update(DictionaryTypeUpdateRequest $request, DictionaryType $dictionary_type)
    {
        $this->setBefore((object)$dictionary_type);

        $dictionary_type->update($request->validated());

        $this->setAfter((object)$dictionary_type);
        $this->saveHistory("Редактирование", ModelType::DictionaryType);

        return new DictionaryTypeResource($dictionary_type);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\DictionaryType $dictionary_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, DictionaryType $dictionary_type)
    {

        $this->setBefore((object)DictionaryType::find($dictionary_type->id));

        $dictionary_type->delete();

        $this->setAfter((object)$dictionary_type);
        $this->saveHistory("Удаление", ModelType::DictionaryType);

        return response()->noContent();
    }
}
