<?php

namespace App\App\CommandBus\Contracts;

use Illuminate\Http\Request;
use App\App\CommandBus\Contracts\ActionInterface;
use Joselfonseca\LaravelTactician\CommandBusInterface;

abstract class ActionAbstract implements ActionInterface
{
	protected $bus;

	protected $request;

	protected $fields;

	protected $command;

	protected $handler;

	protected $middlewares;

	public function __construct(CommandBusInterface $bus, Request $request)
	{
	    $this->bus = $bus;
	    $this->request = $request;
	}

	public function __invoke()
	{
        $this->getBus()->addHandler(
	        					$this->getCommand(), 
	        					$this->getHandler()
        );

        return $this->getBus()->dispatch(
	    						$this->getCommand(), 
	    						$this->getData(), 
	    						$this->getMiddlewares()
    	);
	}

	public function getBus():CommandBusInterface
	{
		return $this->bus;
	}

	public function getCommand():string
	{
		return $this->command;
	}

	public function getHandler():string
	{
		return $this->handler;
	}

	public function getMiddlewares():array
	{
		return $this->middlewares;
	}

	public function getData():array
	{
		return $this->request->only($this->fields);
	}
}