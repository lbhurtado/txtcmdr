<?php

namespace App\Campaign\Notifications\Info;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Notifications\BaseNotification;

class CommanderInfoTagUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.info.tag";

    function params(Contact $notifiable)
    {
        $tag = $notifiable->tags()->first();
        $data = $tag ? "{$tag->code}" : 'none';

        return compact('data');
    }
}