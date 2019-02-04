<?php

namespace App\Campaign\Notifications;

use App\Campaign\Domain\Classes\Command;
use App\Missive\Domain\Models\Contact;

class CommanderHelpUpdated extends BaseNotification
{
    protected $template = "txtcmdr.commander.help";

    function params(Contact $notifiable)
    {
        $flattened = array_reverse(Command::$mappings);

        array_walk($flattened, function(&$value, $key) {
            $value = "{$key} ({$value})";
        });

        $commands = implode(",\n", $flattened);

        return [
            'commands' => $commands
        ];
    }
}
