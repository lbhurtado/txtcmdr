<?php

namespace App\Campaign\Notifications;

use Illuminate\Support\Arr;
use App\Missive\Domain\Models\Contact;

class CommanderPollUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.poll";

    public $queue = 'sms';

    protected $poll_array;

    public function __construct($poll_array)
    {
        $this->poll_array = $poll_array;
    }

    function params(Contact $notifiable)
    {
        $first_name = ucfirst(Arr::first(explode(' ', $notifiable->handle)));

        return [
            'handle' => $first_name,
            'poll' => http_build_query($this->poll_array),
        ];
    }
}
