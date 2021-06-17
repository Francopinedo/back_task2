<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\IredmailMail;


class IredmailMailTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */

    public function transform(IredmailMail $mail)
    {
        return [
            'id'              => $mail->id,
            'mail'            => $mail->mail,
            'secret'          => $mail->secret,
        ];
    }
}
