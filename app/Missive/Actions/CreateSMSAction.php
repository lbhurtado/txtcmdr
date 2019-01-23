<?php

namespace App\Missive\Actions;

use App\App\Jobs\ProcessCommand;
use App\Missive\Jobs\CreateContact;
use App\Charging\Jobs\ChargeAirtime;
use App\Missive\{
		Responders\CreateSMSResponder,
		Domain\Validators\CreateSMSValidator,
		Domain\Services\Handlers\CreateSMSHandler,
		Domain\Services\Commands\CreateSMSCommand
};
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};
use App\App\CommandBus\Contracts\{ActionInterface, ActionAbstract};

class CreateSMSAction extends ActionAbstract implements ActionInterface
{
	protected $fields = ['from', 'to', 'message'];

	protected $command = CreateSMSCommand::class;

	protected $handler = CreateSMSHandler::class;

	protected $middlewares = [
    	CreateSMSValidator::class,
    	CreateSMSResponder::class,
	];

	public function setup()
	{
		$this->getDispatcher()->handle(SMSEvents::CREATED, function ($event) {
			tap($event->getSMS(), function ($sms) {

				\TxtCmdr::setSMS($sms);

				$this->dispatchNow(new CreateContact());
				$this->dispatch(new ProcessCommand());	
				$this->dispatch(new ChargeAirtime());			
			});
		});
	}
}