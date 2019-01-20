<?php

namespace App\Missive\Domain\Services\Commands;

class CreateSMSCommand
{
	public $from;

	public $to;

	public $message;

    public function __construct($from, $to, $message)
    {
 		$this->from = $from;
 		$this->to = $to;
 		$this->message = $message;
    }

    public function getArguments()
    {
    	return [
    		'from' => $this->from,
    		'to' => $this->to,
    		'message' => $this->message,
    	];
    }
}
