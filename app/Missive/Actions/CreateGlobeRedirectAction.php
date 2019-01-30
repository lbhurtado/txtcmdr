<?php

namespace App\Missive\Actions;

use App\Missive\{
		Responders\CreateContactFromGlobeRedirectResponder,
		Domain\Validators\CreateContactFromGlobeRedirectValidator,
		Domain\Services\Handlers\CreateContactFromGlobeRedirectHandler,
		Domain\Services\Commands\CreateContactFromGlobeRedirectCommand
};
use App\App\CommandBus\Contracts\{ActionInterface, ActionAbstract};

class CreateGlobeRedirectAction extends ActionAbstract implements ActionInterface
{
	protected $fields = ['access_token', 'subscriber_number'];

	protected $command = CreateContactFromGlobeRedirectCommand::class;

	protected $handler = CreateContactFromGlobeRedirectHandler::class;

	protected $middlewares = [
    	CreateContactFromGlobeRedirectValidator::class,
    	CreateContactFromGlobeRedirectResponder::class,
	];

	public function setup()
	{

	}
}