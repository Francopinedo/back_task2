<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Project;
use App\Customer;

class ProjectTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'customer'
    ];

    public function transform(Project $project)
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'customer_id' => $project->customer_id,
            'contract_id' => $project->contract_id,
            'customer_name' => $project->customer_name,
            'start' => $project->start,
            'finish' => $project->finish,
            'project_manager_id' => $project->project_manager_id,
            'technical_director_id' => $project->technical_director_id,
            'delivery_manager_id' => $project->delivery_manager_id,
            'sow_number' => $project->sow_number,
            'identificator' => $project->identificator,
            'status' => $project->status,
            'presales_responsable' => $project->presales_responsable,
            'technical_estimator' => $project->technical_estimator,
            'engagement' => $project->engagement,
            'estimated_revenue' => $project->estimated_revenue,
            'estimated_cost' => $project->estimated_cost,
            'estimated_margin' => $project->estimated_margin,
            'estimated_department_margin' => $project->estimated_department_margin,
            'target_margin' => $project->target_margin,
            'financial_deviation_threshold' => $project->financial_deviation_threshold,
            'time_deviation_threshold' => $project->time_deviation_threshold,
            'hours_by_day' => $project->hours_by_day,
            'holy_days' => empty($project->holy_days) ? array() : json_decode($project->holy_days),
            'department_id' => $project->department_id,
            'name_convention' => empty($project->name_convention) ? array() : json_decode($project->name_convention),
            'chatchannel' => $project->Chatroom,
        ];

    }

    public function includeCustomer(Project $project)
    {
        if (empty($project->customer)) {
            $customer = new Customer();
        } else {
            $customer = $project->customer;
        }

        return $this->item($customer, new CustomerTransformer);
    }
}
