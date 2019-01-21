<?php

namespace App\App\CommandBus\Contracts;

use Illuminate\Http\Request;
use Opis\Events\EventDispatcher;
use App\App\Services\TextCommander;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\App\CommandBus\Contracts\ActionInterface;
use Joselfonseca\LaravelTactician\CommandBusInterface;

abstract class ActionAbstract implements ActionInterface
{
	use DispatchesJobs;
	
	protected $txtcmdr;

	protected $bus;

	protected $request;

	protected $fields;

	protected $command;

	protected $handler;

	protected $middlewares;

	protected $dispatcher;

	public function __construct(CommandBusInterface $bus, EventDispatcher $dispatcher, Request $request)
	{
		$this->txtcmdr = app()->make('txtcmdr');
	    $this->bus = $bus;
	    $this->request = $request;
	    $this->dispatcher = $dispatcher;
	}

	public function __invoke()
	{
		$this->setup();

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

	public function getDispatcher()
	{
		return $this->dispatcher;
	}

	public function getService(): TextCommander
	{
		return $this->txtcmdr;
	}

	abstract public function setup();
}