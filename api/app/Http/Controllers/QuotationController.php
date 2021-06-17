<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\Quotation;
use App\Models\QuotationExpense;
use App\Models\QuotationMaterial;
use App\Models\QuotationResource;
use App\Models\QuotationService;
use App\Models\Rate;
use App\Models\TaskExpense;
use App\Models\TaskMaterial;
use App\Models\TaskResource;
use App\Models\TaskService;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\QuotationTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Quotation
 *
 * @Resource("Group Quotation")
 */
class QuotationController extends Controller
{

    /**
     * Obtener
     *
     * @Get("quotations{?project_id}")
     * @Parameters({
     *      @Parameter("project_id", description="ID del proyecto", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "number": "string",
     *        "purchase_order": "string",
     *        "concept": "string",
     *        "from": "date"
     *        "to": "date",
     *        "contact_id": "int",
     *        "currency_id": "int",
     *        "due_date": "date",
     *        "total": "float",
     *        "bill_to": "string",
     *        "remit_to": "string"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = Quotation::query();

        if ($request->has('project_id')) {
            $query->where('absences.project_id', $request->project_id);
        }

        $quotations = $query->get();

        return $this->response->collection($quotations, new QuotationTransformer);
    }

    /**
     * Crear
     *
     * @Post("quotations")
     * @Request({
     *        "project_id": "int",
     *        "number": "string",
     *        "purchase_order": "string",
     *        "concept": "string",
     *        "from": "date"
     *        "to": "date",
     *        "contact_id": "int",
     *        "currency_id": "int",
     *        "due_date": "date",
     *        "total": "float",
     *        "bill_to": "string",
     *        "remit_to": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "number": "string",
     *        "purchase_order": "string",
     *        "concept": "string",
     *        "from": "date"
     *        "to": "date",
     *        "contact_id": "int",
     *        "currency_id": "int",
     *        "due_date": "date",
     *        "total": "float",
     *        "bill_to": "string",
     *        "remit_to": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('project_id') || !$request->has('from') || !$request->has('to') || !$request->has('currency_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $invoice = Quotation::create($data);

        if ($invoice) {
            return $this->response->item($invoice, new QuotationTransformer());
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("quotations/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "number": "string",
     *        "purchase_order": "string",
     *        "concept": "string",
     *        "from": "date"
     *        "to": "date",
     *        "contact_id": "int",
     *        "currency_id": "int",
     *        "due_date": "date",
     *        "total": "float",
     *        "bill_to": "string",
     *        "remit_to": "string"
     *    })
     * })
     */
    public function show($id)
    {
        $invoice = Quotation::with('currency')->findOrFail($id);

        return $this->response->item($invoice, new QuotationTransformer());
    }

    /**
     * Editar
     *
     * @Patch("quotations/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "project_id": "int",
     *        "number": "string",
     *        "purchase_order": "string",
     *        "concept": "string",
     *        "from": "date"
     *        "to": "date",
     *        "contact_id": "int",
     *        "currency_id": "int",
     *        "due_date": "date",
     *        "total": "float",
     *        "bill_to": "string",
     *        "remit_to": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "number": "string",
     *        "purchase_order": "string",
     *        "concept": "string",
     *        "from": "date"
     *        "to": "date",
     *        "contact_id": "int",
     *        "currency_id": "int",
     *        "due_date": "date",
     *        "total": "float",
     *        "bill_to": "string",
     *        "remit_to": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $invoice = Quotation::find($id);

        if ($invoice == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $invoice->update($data);

        if ($invoice) {
            return $this->response->item($invoice, new QuotationTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("quotations/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe"}})
     * })
     */
    public function destroy($id)
    {

        QuotationResource::where('quotation_id', $id)->delete();
        QuotationService::where('quotation_id', $id)->delete();
        QuotationExpense::where('quotation_id', $id)->delete();
        QuotationMaterial::where('quotation_id', $id)->delete();


        $invoice = Quotation::find($id);

        if ($invoice == NULL) {
            return $this->response->error('No existe', 450);
        }

        $invoice->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("quotations/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('quotations')
            ->select(
                'quotations.id',
                'quotations.project_id',
                'quotations.number',

                'quotations.concept',
                'quotations.from',
                'quotations.to',
                'quotations.contact_id',
                'quotations.currency_id',
                'quotations.due_date',
                'quotations.total',
                'quotations.bill_to',
                'quotations.remit_to',
                'quotations.comments',
                'currencies.name AS currency_name',
                'contacts.name AS contact_name'
            )
            ->join('currencies', 'currencies.id', '=', 'quotations.currency_id')
            ->leftJoin('contacts', 'contacts.id', '=', 'quotations.contact_id');

        if ($request->has('project_id')) {
            $query->where('quotations.project_id', $request->project_id);
        }

        $quotations = $query->get();


        return Datatables::of($quotations)->make(true);
    }

    /**
     * Obtener
     *
     * @Get("projects/{id}/count_rows")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "rows": "int"
     *    })
     * })
     */
    public function countRows($id)
    {
        $invoiceResources = QuotationResource::where('quotation_id', $id)->count();
        $invoiceServices = QuotationService::where('quotation_id', $id)->count();
        $invoiceMaterials = QuotationMaterial::where('quotation_id', $id)->count();
        $invoiceExpenses = QuotationExpense::where('quotation_id', $id)->count();

        $count = $invoiceResources + $invoiceServices + $invoiceMaterials + $invoiceExpenses;

        return ['data' => ['rows' => $count]];
    }

    /**
     * Obtener
     *
     * @Get("quotations/{id}/update_from_project_board")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     * })
     */
    public function update_from_project_board($quotationId)
    {
        $quotation = Quotation::join('projects', 'projects.id', '=', 'quotations.project_id')
            ->join('customers', 'projects.customer_id', '=', 'customers.id')
            ->where('quotations.id', $quotationId)->get(['quotations.*', 'customers.company_id',
                'projects.customer_id', 'projects.start', 'projects.finish'])->first();


        $invoice_currency_exchange = ExchangeRate::where('currency_id', $quotation->currency_id)->
        where('company_id', $quotation->company_id)->first();


        //var_dump($invoice_currency_exchange);

        $projectId = $quotation->project_id;

        // borro todo
        QuotationResource::where('quotation_id', $quotationId)->delete();
        QuotationService::where('quotation_id', $quotationId)->delete();
        QuotationExpense::where('quotation_id', $quotationId)->delete();
        QuotationMaterial::where('quotation_id', $quotationId)->delete();

        // obtengo todo de project board
        $projectResources = TaskResource::where('tasks.project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'task_resources.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->join('tasks', 'tasks.id', '=', 'task_resources.task_id', 'left')
            ->join('projects', 'projects.id', '=', 'tasks.project_id', 'left')
            ->groupBy('task_resources.id')
            ->whereNotNull('user_id')->get(['tasks.project_id', 'task_resources.user_id',
                'task_resources.project_role_id', 'task_resources.seniority_id', 'task_resources.task_id',
                'task_resources.rate as amount', 'task_resources.quantity', 'task_resources.currency_id',
                'exchange_rates.value as exhange_value']);

        $projectServices = TaskService::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'task_services.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->join('tasks', 'tasks.id', '=', 'task_services.task_id', 'left')
            ->join('projects', 'projects.id', '=', 'tasks.project_id', 'left')
            ->groupBy('task_services.id')
            ->where('reimbursable', 1)->get(['task_services.*', 'exchange_rates.value as exhange_value']);

        $projectExpenses = TaskExpense::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'task_expenses.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->join('tasks', 'tasks.id', '=', 'task_expenses.task_id', 'left')
            ->join('projects', 'projects.id', '=', 'tasks.project_id', 'left')
            ->groupBy('task_expenses.id')
            ->where('reimbursable', 1)->get(['task_expenses.*', 'exchange_rates.value as exhange_value']);

        $projectMaterials = TaskMaterial::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'task_materials.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->join('tasks', 'tasks.id', '=', 'task_materials.task_id', 'left')
            ->join('projects', 'projects.id', '=', 'tasks.project_id', 'left')
            ->groupBy('task_materials.id')
            ->where('reimbursable', 1)->get(['task_materials.*', 'exchange_rates.value as exhange_value']);


        foreach ($projectResources as $projectResource) {
            $user = User::where('users.id', '=', $projectResource->user_id)
                ->join('cities', 'cities.id', '=', 'users.city_id')->get(['users.*', 'cities.country_id'])->first();


            // calculo el renglon para WorkingHours
            if (!empty($user->office_id)) {


                if (!empty($projectResource->rate_id)) {
                    $rate = Rate::find($projectResource->rate_id);
                    $type = $rate->title;
                } else {
                    $type = '';
                }

                $exchangeresult = exchange($projectResource, $invoice_currency_exchange);


                // echo $rate." ";
                $item = QuotationResource::create([
                    'quotation_id' => $quotationId,
                    'user_id' => $projectResource->user_id,
                    'project_role_id' => $projectResource->project_role_id,
                    'seniority_id' => ($projectResource->seniority_id != null) ? $projectResource->seniority_id : $user->seniority_id,
                    'office_id' => ($projectResource->office_id != null) ? $projectResource->office_id : $user->office_id,
                    'country_id' => ($projectResource->country_id != null) ? $projectResource->country_id : $user->country_id,
                    'city_id' => ($projectResource->city_id != null) ? $projectResource->city_id : $user->city_id,
                    'currency_id' => $quotation->currency_id,
                    'workplace' => ($projectResource->workplace != null) ? $projectResource->workplace : $user->workplace,
                    'load' => 100,
                    'comments' => $projectResource->comments,
                    'rate' => $exchangeresult['rate'],
                    'rate_id' => $projectResource->rate_id,
                    'hours' => isset($projectResource->quantity)?$projectResource->quantity:0,
                    'type' => $type,
                    'task_id' => $projectResource->task_id
                    //'type'            => $type.' Working Hours'
                ]);
            }


        }

        foreach ($projectServices as $projectService) {


            $exchangeresult = exchange($projectService, $invoice_currency_exchange);

            $item = QuotationService::create([
                'quotation_id' => $quotationId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $quotation->currency_id,
                'detail' => $projectService->detail,
            ]);
        }

        foreach ($projectExpenses as $projectExpense) {

            $exchangeresult = exchange($projectExpense, $invoice_currency_exchange);


            $item = QuotationExpense::create([
                'quotation_id' => $quotationId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $quotation->currency_id,
                'detail' => $projectExpense->detail,
            ]);
        }

        foreach ($projectMaterials as $projectMaterial) {
            // echo $projectMaterial->amount;
            $exchangeresult = exchange($projectMaterial, $invoice_currency_exchange);
            $item = QuotationMaterial::create([
                'quotation_id' => $quotationId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $quotation->currency_id,
                'detail' => $projectMaterial->detail,
            ]);
        }

        $this->update_total($quotation->id);
        return $this->response->noContent();
    }


    public function update_total($id)
    {
        $invoice = Quotation::find($id);

        if ($invoice == NULL) {
            return $this->response->error('No existe', 450);
        }

        $total = 0;

        $invoiceResources = QuotationResource::where('quotation_id', $invoice->id)->get();
        $invoiceServices = QuotationService::where('quotation_id', $invoice->id)->get();
        $invoiceExpenses = QuotationExpense::where('quotation_id', $invoice->id)->get();
        $invoiceMaterials = QuotationMaterial::where('quotation_id', $invoice->id)->get();


        foreach ($invoiceResources as $invoiceResource) {
            $total = $total + ($invoiceResource->rate * $invoiceResource->hours);
        }

        foreach ($invoiceServices as $invoiceService) {
            $total = $total + $invoiceService->amount;
        }

        foreach ($invoiceExpenses as $invoiceExpense) {

            $total = $total + $invoiceExpense->amount;
        }

        foreach ($invoiceMaterials as $invoiceMaterial) {
            $total = $total + $invoiceMaterial->amount;

        }


        $data = array('total' => $total);

        $invoice->update($data);

        if ($invoice) {
            //return $this->response->noContent();
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }
}

?>