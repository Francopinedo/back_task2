<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\CompanyChatRoom;


class CompanyChatRoomTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */

    public function transform(CompanyChatRoom $chatRoom)
    {
        return [
            'id' => $chatRoom->id,
            'name' => $chatRoom->name,
            'fullname' => $chatRoom->fullname,
            'path' => $chatRoom->path,
            'type' => $chatRoom->type,
            'users' => $chatRoom->users,
        ];
    }
}
