<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\IredmailDomain;


class IredmailDomainTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */

    public function transform(IredmailDomain $domain)
    {
        return [
            'id'              => $domain->id,
            'domain'            => $domain->domain,
            'mails' => $domain->mails,
        ];
    }
}
