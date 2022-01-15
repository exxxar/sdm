<?php

namespace App\Http\Controllers;

use App\Classes\OperationHistory;
use App\Enums\ModelType;
use App\Http\Requests\ReportTemplateStoreRequest;
use App\Http\Requests\ReportTemplateUpdateRequest;
use App\Http\Resources\ReportTemplateCollection;
use App\Http\Resources\ReportTemplateResource;
use App\Models\ReportTemplate;
use Illuminate\Http\Request;

class ReportTemplateController extends Controller
{
    use OperationHistory;

    public function __construct()
    {
        $this->middleware('permission:Просмотр шаблонов отчетов')->only('index', 'show');
        $this->middleware('permission:Удаление шаблонов отчетов')->only('destroy', 'forceDelete');
        $this->middleware('permission:Создание шаблонов отчетов')->only('store', 'create');
        $this->middleware('permission:Изменение шаблонов отчетов')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report_templates = ReportTemplate::all();

        return new ReportTemplateCollection($report_templates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param \App\Http\Requests\ReportTemplateStoreRequest $request
     * @return \App\Http\Resources\ReportTemplateResource
     */
    public function store(ReportTemplateStoreRequest $request)
    {
        $report_template = ReportTemplate::create($request->validated());

        $this->setAfter((object)$report_template);
        $this->saveHistory("Создание", ModelType::ReportTemplate);

        return new ReportTemplateResource($report_template);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReportTemplate $report_template
     * @return \App\Http\Resources\ReportTemplateResource
     */
    public function show(Request $request, ReportTemplate $report_template)
    {
        return new ReportTemplateResource($report_template);
    }

    /**
     * @param \App\Http\Requests\ReportTemplateUpdateRequest $request
     * @param \App\Models\ReportTemplate $report_template
     * @return \App\Http\Resources\ReportTemplateResource
     */
    public function update(ReportTemplateUpdateRequest $request, ReportTemplate $report_template)
    {
        $this->setBefore((object)ReportTemplate::find($report_template->id));

        $report_template->update($request->validated());

        $this->setAfter((object)$report_template);
        $this->saveHistory("Редактирование", ModelType::ReportTemplate);

        return new ReportTemplateResource($report_template);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReportTemplate $report_template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ReportTemplate $report_template)
    {

        $this->setBefore((object)$report_template);

        $report_template->delete();

        $this->setAfter((object)$report_template);
        $this->saveHistory("Удаление", ModelType::ReportTemplate);

        return response()->noContent();
    }
}
