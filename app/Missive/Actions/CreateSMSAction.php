<?php

namespace App\Missive\Actions;

use Illuminate\Http\Request;
use App\Missive\{
		Domain\Services\Commands\CreateSMSCommand,
		Domain\Services\Handlers\CreateSMSHandler,
		Domain\Validators\CreateSMSValidator,
		Responders\CreateSMSResponder
	};
use Joselfonseca\LaravelTactician\CommandBusInterface;

class CreateSMSAction
{
	protected $bus;

	protected $request;

	protected $command = CreateSMSCommand::class;

	protected $handler = CreateSMSHandler::class;

	protected $middlewares = [
    	CreateSMSValidator::class,
    	CreateSMSResponder::class
	];

	public function __construct(CommandBusInterface $bus, Request $request)
	{
	    $this->bus = $bus;
	    $this->request = $request;
	}

	public function __invoke()
	{
        $this->bus->addHandler($this->command, $this->handler);

        return $this->bus->dispatch($this->command, $this->getData(), $this->middlewares);
	}

	protected function getData()
	{
		return $this->request->only('from', 'to', 'message');
	}
}