<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\AdditionalHour;
use App\Models\Invoice;
use App\Models\InvoiceDiscount;
use App\Models\InvoiceExpense;
use App\Models\InvoiceMaterial;
use App\Models\InvoiceResource;
use App\Models\InvoiceService;
use App\Models\InvoiceDebitCredit;
use App\Models\InvoiceTax;
use App\Models\ProjectExpense;
use App\Models\ProjectMaterial;
use App\Models\ProjectResource;
use App\Models\ProjectService;
use App\Models\DebitCredit;
use App\Models\Rate;
use App\Models\User;
use App\Models\WorkingHour;
use App\Office;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\InvoiceTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Invoice
 *
 * @Resource("Group Invoice")
 */
class InvoiceController extends Controller
{

    /**
     * Obtener
     *
     * @Get("invoices{?project_id}")
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
        $query = Invoice;

        if ($request->has('project_id')) {
            $query->where('absences.project_id', $request->project_id);
        }

        $invoices = $query->get();

        return $this->response->collection($invoices, new InvoiceTransformer);
    }

    /**
     * Crear
     *
     * @Post("invoices")
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

        $invoice = Invoice::create($data);

        if ($invoice) {
            return $this->response->item($invoice, new InvoiceTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("invoices/{id}")
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
        $invoice = Invoice::with('currency')->findOrFail($id);

        return $this->response->item($invoice, new InvoiceTransformer);
    }

    /**
     * Editar
     *
     * @Patch("invoices/{id}")
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
        $invoice = Invoice::find($id);

        if ($invoice == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $invoice->update($data);

        if ($invoice) {
            return $this->response->item($invoice, new InvoiceTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("invoices/{id}")
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

        InvoiceResource::where('invoice_id', $id)->delete();
        InvoiceService::where('invoice_id', $id)->delete();
        InvoiceExpense::where('invoice_id', $id)->delete();
        InvoiceMaterial::where('invoice_id', $id)->delete();
        InvoiceDiscount::where('invoice_id', $id)->delete();
        InvoiceTax::where('invoice_id', $id)->delete();
        InvoiceDebitCredit::where('invoice_id', $id)->delete();


        $invoice = Invoice::find($id);

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
     * @Get("invoices/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('invoices')
            ->select(
                'invoices.id',
                'invoices.project_id',
                'invoices.number',
                'invoices.purchase_order',
                'invoices.concept',
                'invoices.from',
                'invoices.to',
                'invoices.contact_id',
                'invoices.currency_id',
                'invoices.due_date',
                'invoices.total',
                'invoices.bill_to',
                'invoices.remit_to',
                'invoices.comments',
                'currencies.name AS currency_name',
                'contacts.name AS contact_name'
            )
            ->join('currencies', 'currencies.id', '=', 'invoices.currency_id')
            ->leftJoin('contacts', 'contacts.id', '=', 'invoices.contact_id');

        if ($request->has('project_id')) {
            $query->where('invoices.project_id', $request->project_id);
        }

        $invoices = $query->get();

        return Datatables::of($invoices)->make(true);
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
        $invoiceResources = InvoiceResource::where('invoice_id', $id)->count();
        $invoiceServices = InvoiceService::where('invoice_id', $id)->count();
        $invoiceMaterials = InvoiceMaterial::where('invoice_id', $id)->count();
        $invoiceExpenses = InvoiceExpense::where('invoice_id', $id)->count();
        $invoiceAdjustemt = InvoiceDebitCredit::where('invoice_id', $id)->count();

        $count = $invoiceResources + $invoiceServices + $invoiceMaterials + $invoiceExpenses + $invoiceAdjustemt;

        return ['data' => ['rows' => $count]];
    }

    /**
     * Obtener
     *
     * @Get("invoices/{id}/update_from_project_board")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     * })
     */
    public function update_from_project_board($invoiceId)
    {
        $invoice = Invoice::join('projects', 'projects.id', '=', 'invoices.project_id')
            ->join('customers', 'projects.customer_id', '=', 'customers.id')
            ->where('invoices.id', $invoiceId)->get(['invoices.*', 'customers.company_id',
                'projects.customer_id', 'projects.start', 'projects.finish'])->first();


        $invoice_currency_exchange = ExchangeRate::where('currency_id', $invoice->currency_id)->
        where('company_id', $invoice->company_id)->first();


        //var_dump($invoice_currency_exchange);

        $projectId = $invoice->project_id;

        // borro todo
        InvoiceResource::where('invoice_id', $invoiceId)->delete();
        InvoiceService::where('invoice_id', $invoiceId)->delete();
        InvoiceExpense::where('invoice_id', $invoiceId)->delete();
        InvoiceMaterial::where('invoice_id', $invoiceId)->delete();
        InvoiceDebitCredit::where('invoice_id', $invoiceId)->delete();

        // obtengo todo de project board
        $projectResources = ProjectResource::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'project_resources.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->groupBy('project_resources.id')
            ->where('project_resources.type','=','ordinary')
            ->whereNotNull('user_id')->get(['project_resources.project_id', 'project_resources.user_id',
                'project_resources.project_role_id', 'project_resources.seniority_id', 'project_resources.rate_id',
                'project_resources.rate as amount', 'project_resources.currency_id', 'project_resources.load',
                'project_resources.workplace', 'project_resources.comments', 'exchange_rates.value as exhange_value']);

        $projectServices = ProjectService::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'project_services.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->groupBy('project_services.id')
            ->where('reimbursable', 1)->get(['project_services.*', 'exchange_rates.value as exhange_value']);

        $projectExpenses = ProjectExpense::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'project_expenses.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->groupBy('project_expenses.id')
            ->where('reimbursable', 1)->get(['project_expenses.*', 'exchange_rates.value as exhange_value']);

        $projectMaterials = ProjectMaterial::where('project_id', $projectId)
            ->join('currencies', 'currencies.id', '=', 'project_materials.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->groupBy('project_materials.id')
            ->where('reimbursable', 1)->get(['project_materials.*', 'exchange_rates.value as exhange_value']);

        $projectAdjustmentsPlus = DebitCredit::where('project_id', $projectId)->where('signs', '+')
            ->join('currencies', 'currencies.id', '=', 'debit_credit.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->groupBy('debit_credit.id')
            ->get(['debit_credit.*', 'exchange_rates.value as exhange_value']);

             $projectAdjustmentsMinus = DebitCredit::where('project_id', $projectId)->where('signs', '-')
            ->join('currencies', 'currencies.id', '=', 'debit_credit.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->groupBy('debit_credit.id')
            ->get(['debit_credit.*', 'exchange_rates.value as exhange_value']);


           
        foreach ($projectResources as $projectResource) {
            $user = User::find($projectResource->user_id);


            // calculo el renglon para WorkingHours
            if (!empty($user->office_id)) {
                $totalHours = 0;

               // echo $invoice->start;
                //$begin = new DateTime($invoice->start);
                //$end = new DateTime($invoice->finish);
               // $end->setTime(0, 0, 1);
               // $interval = DateInterval::createFromDateString('1 day');
                //$period = new DatePeriod($begin, $interval, $end);


              //  foreach ($period as $dt) {
                    $requestSend =array('project'=>$invoice->project_id, 'customer'=>$invoice->customer_id,
                        'period_to'=> $invoice->finish, 'period_from'=>
                            $invoice->start, 'user_id'=>$projectResource->user_id, 'company'=>$invoice->company_id);

                    $requestSend = new \Illuminate\Http\Request($requestSend);
                    $workingHoursFromApi =   app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

  
                    $workingHoursFromApi = $workingHoursFromApi->getData();
                    $workingHoursFromApi=$workingHoursFromApi->data;
 if(!empty($workingHoursFromApi))
        {   
                if (is_numeric($workingHoursFromApi->hours) && $workingHoursFromApi->hours >= 0) {
                    $totalHours = $totalHours + $workingHoursFromApi->hours;
                }
         }           
              //  }



                if (!empty($projectResource->rate_id)) {
                    $rate = Rate::find($projectResource->rate_id);
                    $type = $rate->title;
                } else {
                    $type = '';
                }

                $exchangeresult = exchange($projectResource, $invoice_currency_exchange);



                // echo $rate." ";
                $item = InvoiceResource::create([
                    'invoice_id' => $invoiceId,
                    'user_id' => $projectResource->user_id,
                    'project_role_id' => $projectResource->project_role_id,
                    'seniority_id' => $projectResource->seniority_id,
                    'currency_id' => $invoice->currency_id,
                    'workplace' => $projectResource->workplace,
                    'load' => $projectResource->load,
                    'comments' => $projectResource->comments,
                    'rate' => $exchangeresult['rate'],
                    'rate_id' => $projectResource->rate_id,
                    'hours' => $totalHours,
                    'type' => $type
                    //'type'            => $type.' Working Hours'
                ]);
            }

            // calculo los renglones para additional Hours
            $additionalHoursTypesCount = AdditionalHour::
            join('rates', 'rates.id', '=', 'additional_hours.rate_id', 'left')
                ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'rates.currency_id', 'left')
                ->where('user_id', $user->id)
                ->where('project_id', $projectResource->project_id)
                ->groupBy('project_role_id')->get(['rates.value as amount', 'exchange_rates.value as exhange_value', 'additional_hours.*']);

            foreach ($additionalHoursTypesCount as $addH) {


                $additionalHours = AdditionalHour::where('user_id', $user->id)
                    ->where('project_id', $projectResource->project_id)
                    ->where('project_role_id', $addH->project_role_id)
                    ->whereBetween('date', array($invoice->from, $invoice->to))
                    ->get();


                $totalHours = 0;
                foreach ($additionalHours as $ah) {
                    $totalHours = $totalHours + $ah->hours;
                }


                $rate = Rate::find($addH->rate_id);

                if (is_object($rate)) {
                    $type = $rate->title;
                } else {
                    $type = '';
                }


                $exchangeresult = exchange($addH, $invoice_currency_exchange);

                //  echo $exchangeresult['rate'] . " ";
                $item = InvoiceResource::create([
                    'invoice_id' => $invoiceId,
                    'user_id' => $projectResource->user_id,
                    'project_role_id' => $addH->project_role_id,
                    'seniority_id' => $addH->seniority_id,
                    'currency_id' => $invoice->currency_id,
                    'workplace' => $addH->workplace,
                    'load' => $projectResource->load,
                    'comments' => $projectResource->comments,
                    'rate' => $exchangeresult['rate'],
                    'rate_id' => isset($rate->id) ? $rate->id : NULL,
                    'hours' => $totalHours,
                    'type' => $type . ' Additional Hours'
                    //'type'            => $type.' Aditional Hours'  // Esto lo agrego Giusseppe ,
                ]);

            }
        }

        foreach ($projectServices as $projectService) {


            $exchangeresult = exchange($projectService, $invoice_currency_exchange);

            $item = InvoiceService::create([
                'invoice_id' => $invoiceId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $invoice->currency_id,
                'detail' => $projectService->detail,
            ]);
        }

        foreach ($projectExpenses as $projectExpense) {

            $exchangeresult = exchange($projectExpense, $invoice_currency_exchange);


            $item = InvoiceExpense::create([
                'invoice_id' => $invoiceId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $invoice->currency_id,
                'detail' => $projectExpense->detail,
            ]);
        }

        foreach ($projectMaterials as $projectMaterial) {
            // echo $projectMaterial->amount;
            $exchangeresult = exchange($projectMaterial, $invoice_currency_exchange);
            $item = InvoiceMaterial::create([
                'invoice_id' => $invoiceId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $invoice->currency_id,
                'detail' => $projectMaterial->detail,
            ]);
        }

         foreach ($projectAdjustmentsPlus as $projectAdjustmentsP) {
            // echo $projectMaterial->amount;
            $exchangeresult = exchange($projectAdjustmentsP, $invoice_currency_exchange);
            $item = InvoiceDebitCredit::create([
                'invoice_id' => $invoiceId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $invoice->currency_id,
                'detail' => $projectAdjustmentsP->detail,
                 'signs' => '+',
            ]);
        }

             foreach ($projectAdjustmentsMinus as $projectAdjustmentsM) {
            // echo $projectMaterial->amount;
            $exchangeresult = exchange($projectAdjustmentsM, $invoice_currency_exchange);
            $item = InvoiceDebitCredit::create([
                'invoice_id' => $invoiceId,
                'amount' => $exchangeresult['rate'],
                'cost' => $exchangeresult['cost'],
                'currency_id' => $invoice->currency_id,
                'detail' => $projectAdjustmentsM->detail,
                 'signs' => '-',
            ]);
        }

        $this->update_total($invoice->id);
        return $this->response->noContent();
    }


    public function update_total($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice == NULL) {
            return $this->response->error('No existe', 450);
        }

        $total = 0;
        $totalAM=0;
        $invoiceResources = InvoiceResource::where('invoice_id', $invoice->id)->get();
        $invoiceServices = InvoiceService::where('invoice_id', $invoice->id)->get();
        $invoiceExpenses = InvoiceExpense::where('invoice_id', $invoice->id)->get();
        $invoiceMaterials = InvoiceMaterial::where('invoice_id', $invoice->id)->get();
        $invoiceTaxes = InvoiceTax::where('invoice_id', $invoice->id)->get();
        $invoiceDiscounts = InvoiceDiscount::where('invoice_id', $invoice->id)->get();
         $invoiceAdjustmentP = InvoiceDebitCredit::where('invoice_id', $invoice->id)->where('signs','+')->get();
          $invoiceAdjustmentM = InvoiceDebitCredit::where('invoice_id', $invoice->id)->where('signs','-')->get();

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
         foreach ($invoiceAdjustmentP as $invoiceAP) {
            $total = $total + $invoiceAP->amount;

        }
         foreach ($invoiceAdjustmentM as $invoiceAM) {
            $totalAM = $totalAM + $invoiceAM->amount;

        }
    $total = $total-$totalAM;
        $totaldiscountspercent = 0;
        $totaldiscounts = 0;
        foreach ($invoiceDiscounts as $invoiceDiscount) {
            $rate = $invoiceDiscount->amount;
            if ($rate == null || $rate == 0 || $rate == '') {
                $totaldiscountspercent = $totaldiscountspercent + $invoiceDiscount->percentage;
            } else {
                $totaldiscounts = $totaldiscounts + $invoiceDiscount->amount;
            }

        }
        if ($totaldiscountspercent > 0) {

            $totaldiscounts = $totaldiscounts + (($total * $totaldiscountspercent) / 100);
        }
        $total = $total - $totaldiscounts;

        $totaltaxes = 0;
        $totaltaxespercent = 0;
        foreach ($invoiceTaxes as $invoiceTax) {
            $rate = $invoiceTax->amount;

            if ($rate == null || $rate == 0 || $rate == '') {

                $totaltaxespercent = $totaltaxespercent + $invoiceTax->percentage;
            } else {
                $totaltaxes = $totaltaxes + $invoiceTax->amount;

            }
        }

        if ($totaltaxespercent > 0) {

            $totaltaxes = $totaltaxes + (($total * $totaltaxespercent) / 100);
        }

        $total = $total + $totaltaxes;

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