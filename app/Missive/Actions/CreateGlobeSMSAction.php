<?php

namespace App\Missive\Actions;

use App\App\Facades\TxtCmdr;
use App\App\Jobs\ProcessCommand;
use App\Charging\Jobs\ChargeAirtime;
use App\Missive\{
		Responders\CreateSMSResponder,
		Domain\Validators\CreateSMSValidator,
		Domain\Services\Handlers\CreateSMSHandler,
		Domain\Services\Commands\CreateGlobeSMSCommand
};
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};
use App\App\CommandBus\Contracts\{ActionInterface, ActionAbstract};

class CreateGlobeSMSAction extends ActionAbstract implements ActionInterface
{
	protected $fields = ['inboundSMSMessageList'];

	protected $command = CreateGlobeSMSCommand::class;

	protected $handler = CreateSMSHandler::class;

	protected $middlewares = [
    	CreateSMSValidator::class,
    	CreateSMSResponder::class,
	];

	public function setup()
	{
		$this->getDispatcher()->handle(SMSEvents::CREATED, function (SMSEvent $event) {
			tap($event->getSMS(), function ($sms) {

				TxtCmdr::setSMS($sms);

				$this->dispatchNow(new ProcessCommand());	
				$this->dispatch(new ChargeAirtime($sms));		
			});
		});
	}
}