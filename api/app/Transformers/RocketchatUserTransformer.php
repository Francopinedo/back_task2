<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\RocketChatUser;


class RocketchatUserTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */

    public function transform(RocketChatUser $rcuser)
    {
        return [
            'id'              => $rcuser->id,
            'user'            => $rcuser->rcuser,
            'pass'          => $rcuser->rcpass,
            'owner'          => $rcuser->user,
            'company'          => $rcuser->company,
        ];
    }
}
