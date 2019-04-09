<?php

namespace App\Missive\Domain\Services\Commands;

use App\App\CommandBus\Contracts\CommandInterface;

class CreateTelerivetSMSCommand implements CommandInterface
{
    public $from;

    public $to;

    public $message;

    public function __construct($from_number, $to_number, $content)
    {
        $this->from = $from_number;
        $this->to = $to_number;
        $this->message = $content;
    }

    public function getProperties():array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'message' => $this->message,
        ];
    }
}
