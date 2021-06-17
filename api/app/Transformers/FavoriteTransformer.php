<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Favorite;

class FavoriteTransformer extends TransformerAbstract
{

    public function transform(Favorite $favorite)
    {
        return [
			'id'    => $favorite->id,
			'title' => $favorite->title,
			'url'   => $favorite->url,
			'order' => $favorite->order
        ];
    }
}