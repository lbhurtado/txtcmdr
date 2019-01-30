<?php

namespace App\Missive\Domain\Services\Handlers;

use App\Missive\Domain\Repositories\SMSRepository;
use App\App\CommandBus\Contracts\HandlerInterface;
use App\App\CommandBus\Contracts\CommandInterface;

class CreateSMSHandler implements HandlerInterface
{
	protected $smss;

    public function __construct(SMSRepository $smss)
    {
    	$this->smss = $smss;
    }

    public function handle(CommandInterface $command)
    {
    	$this->smss->create([
    		   'from' => $command->from,
    		     'to' => $command->to,
    		'message' => $command->message,
    	]);
    }
}
