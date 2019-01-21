<?php

namespace App\Missive\Actions;

use App\Missive\{
		Responders\CreateSMSResponder,
		Domain\Validators\CreateSMSValidator,
		Domain\Services\Handlers\CreateSMSHandler,
		Domain\Services\Commands\CreateSMSCommand
};
use App\App\CommandBus\Contracts\{ActionInterface, ActionAbstract};
use Opis\Events\{Event,EventDispatcher};
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};
use App\Missive\Jobs\CreateContact;


class CreateSMSAction extends ActionAbstract implements ActionInterface
{
	protected $fields = ['from', 'to', 'message'];

	protected $command = CreateSMSCommand::class;

	protected $handler = CreateSMSHandler::class;

	protected $middlewares = [
    	CreateSMSValidator::class,
    	CreateSMSResponder::class,
	];

	public function arrange()
	{
		$this->dispatcher->handle(SMSEvents::CREATED, function ($event) {
			$this->dispatchNow(new CreateContact($event->getSMS()->from));
			// CreateContact::dispatch($event->getSMS()->from);
		  	$this->txtcmdr->execute($event->getSMS()->message);
		});
	}

	public function getRequest()
	{
		return $this->request;
	}
}