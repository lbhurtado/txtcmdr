<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use League\Pipeline\StageInterface;
use Opis\String\UnicodeString as wstring;
use Symfony\Component\Process\Exception\LogicException;

abstract class BaseStage implements StageInterface
{
	protected $parameters;

 	protected $notifications = [];

 	protected function getParameters()
 	{
 		return $this->parameters;
 	}

    protected function explodedParameters()
    {
        return json_encode($this->getParameters());
    }

 	protected function setParameters($parameters)
 	{
 		$this->parameters = $parameters;
 		
 		return $this;
 	}

    protected function getCommander()
    {
        return \TxtCmdr::commander();
    }

    protected function getNotification()
    {
        return Arr::get($this->notifications, $this->getParameters()['command']);
    }

    public function __invoke($parameters)
    {
    	$this->setParameters($parameters);

    	$this->execute();
        
        \Log::info(wstring::from(static::class)
                                ->append('::')
                                ->append(__METHOD__)
                                ->append(json_encode($this->getParameters()))
        );

    	return $this->getParameters();
    }

    public function halt()
    {
        throw new LogicException();
    }

    abstract function execute();
}