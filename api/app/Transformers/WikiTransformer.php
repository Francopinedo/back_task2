<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Wiki;

class WikiTransformer extends TransformerAbstract
{

  public function transform(Wiki $wiki)
  {
     return [
     	'id'					=> $wiki->id,
	  	'customer_id' 			=> $wiki->customer_id,
	  	'project_id' 			=> $wiki->project_id,
	  	'user_id'				=> $wiki->user_id,
	  	'process_group_code' 	=> $wiki->process_group_code,
	  	'knowledge_code' 		=> $wiki->knowledge_code,
	  	'swot_code' 			=> $wiki->swot_code,
	  	'explanation' 			=> $wiki->explanation,
	  	'action_taken' 			=> $wiki->action_taken,
	  	'additionals_comments' 	=> $wiki->additionals_comments,
	  	'attached_file' 		=> $wiki->attached_file,
    ];
  }
}