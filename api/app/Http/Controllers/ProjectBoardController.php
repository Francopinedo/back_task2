<?php

namespace App\Http\Controllers;

use App\Models\AdditionalHour;
use App\Models\ContractExpense;
use App\Models\ContractMaterial;
use App\Models\ContractResource;
use App\Models\ContractService;
use App\Models\Project;
use App\Models\ProjectExpense;
use App\Models\ProjectMaterial;
use App\Models\ProjectResource;
use App\Models\ProjectService;
use App\Models\Rate;
use App\Models\TeamUser;
use DB;

/**
 * Modulo de projectBoard
 *
 * @Resource("Group ProjectBoard")
 */
class ProjectBoardController extends Controller
{

    /**
     * Obtener
     *
     * @Get("project_board/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     * })
     */
    public function update_from_contract($id)
    {
        $project = Project::findOrFail($id);

        // borro todo
        ProjectResource::where('project_id', $project->id)->delete();
        ProjectService::where('project_id', $project->id)->delete();
        ProjectExpense::where('project_id', $project->id)->delete();
        ProjectMaterial::where('project_id', $project->id)->delete();

        $contractResources = ContractResource::join('contracts', 'contracts.id', '=', 'contract_resources.contract_id')
            ->where('project_id', $project->id)->get(['contract_resources.*', 'contracts.amendment_number']);
        $contractServices = ContractService::join('contracts', 'contracts.id', '=', 'contract_services.contract_id')
            ->where('project_id', $project->id)->get(['contract_services.*', 'contracts.amendment_number']);
        $contractExpenses = ContractExpense::join('contracts', 'contracts.id', '=', 'contract_expenses.contract_id')
            ->where('project_id', $project->id)->get(['contract_expenses.*', 'contracts.amendment_number']);
        $contractMaterials = ContractMaterial::join('contracts', 'contracts.id', '=', 'contract_materials.contract_id')
            ->where('project_id', $project->id)->get(['contract_materials.*', 'contracts.amendment_number']);

        foreach ($contractResources as $contractResource) {
            for ($i = 0; $i < $contractResource->qty; $i++) {
                $item = ProjectResource::create([
                    'project_id' => $project->id,
                    'project_role_id' => $contractResource->project_role_id,
                    'seniority_id' => $contractResource->seniority_id,
                    'currency_id' => $contractResource->currency_id,
                    'load' => $contractResource->load,
                    'type' => 'ordinary',
                    'workplace' => $contractResource->workplace,
                    'rate' => $contractResource->rate,
                    'rate_id' => $contractResource->rate_id,
                    'comments' => $contractResource->amendment_number != '' ? 'Amendment Number ' . $contractResource->amendment_number : ''
                ]);
            }


        }


        $teams = TeamUser::where('project_id', '=', $project->id)->get();

        foreach ($teams as $team) {

            // calculo los renglones para additional Hours
            $additionalHoursTypesCount = AdditionalHour::
            join('rates', 'rates.id', '=', 'additional_hours.rate_id', 'left')
                ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'rates.currency_id', 'left')
                ->where('user_id', $team->user_id)
                ->where('project_id', $team->project_id)
                ->groupBy('rate_id')->get(['rates.value as amount', 'exchange_rates.value', 'additional_hours.*']);

            foreach ($additionalHoursTypesCount as $addH) {


                $additionalHours = AdditionalHour::where('user_id', $team->user_id)
                    ->where('project_id', $team->project_id)
                    ->where('rate_id', $addH->rate_id)
                    ->whereBetween('date', array($project->start, $project->finish))
                    ->get();


                $totalHours = 0;
                foreach ($additionalHours as $ah) {
                    $totalHours = $totalHours + $ah->hours;
                }


                $rate = Rate::find($addH->rate_id);

                if ($totalHours > 0) {

                    $item = ProjectResource::create([
                        'project_id' => $project->id,
                        'project_role_id' => $rate->project_role_id,
                        'user_id' => $addH->user_id,
                        'seniority_id' => $rate->seniority_id,
                        'currency_id' => $rate->currency_id,
                        'load' => $rate->load,
                        'type' => 'additional',
                        'workplace' => $rate->workplace,
                        'rate' => $rate->value,
                        'rate_id' => $rate->id,
                        'comments' => $contractResource->amendment_number != '' ? 'Amendment Number ' . $contractResource->amendment_number : ''
                    ]);


                }

            }
        }


        foreach ($contractServices as $contractService) {
            $item = ProjectService::create([
                'project_id' => $project->id,
                'cost' => $contractService->cost,
                'frequency' => $contractService->frequency,
                'amount' => $contractService->amount,
                'currency_id' => $contractService->currency_id,
                'detail' => $contractService->detail,
                'service_id' => $contractService->service_id,
                'reimbursable' => $contractService->reimbursable,
            ]);
        }

        foreach ($contractExpenses as $contractExpense) {
            $item = ProjectExpense::create([
                'project_id' => $project->id,
                'cost' => $contractExpense->cost,
                'amount' => $contractExpense->amount,
                'frequency' => $contractExpense->frequency,
                'currency_id' => $contractExpense->currency_id,
                'detail' => $contractExpense->detail,
                'expense_id' => $contractExpense->expense_id,
                'reimbursable' => $contractExpense->reimbursable,
            ]);
        }

        foreach ($contractMaterials as $contractMaterial) {
            $item = ProjectMaterial::create([
                'project_id' => $project->id,
                'cost' => $contractMaterial->cost,
                'frequency' => $contractMaterial->frequency,
                'amount' => $contractMaterial->amount,
                'currency_id' => $contractMaterial->currency_id,
                'detail' => $contractMaterial->detail,
                'material_id' => $contractMaterial->material_id,
                'reimbursable' => $contractMaterial->reimbursable,
            ]);
        }

        return $this->response->noContent();
    }
}

?>