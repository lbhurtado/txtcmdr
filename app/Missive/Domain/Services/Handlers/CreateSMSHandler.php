<?php

namespace App\Missive\Domain\Services\Handlers;

use App\Missive\Domain\Repositories\SMSRepository;
use App\Missive\Domain\Services\Commands\CreateSMSCommand;

class CreateSMSHandler
{
	protected $smss;

    public function __construct(SMSRepository $smss)
    {
    	$this->smss = $smss;
    }

    public function handle(CreateSMSCommand $command)
    {
    	$this->smss->create([
    		'from' => $command->from,
    		'to' => $command->to,
    		'message' => $command->message,
    	]);
    	
        \Log::info("InitializeHandler::handle");
        \Log::info($command->getArguments());
    }
}
