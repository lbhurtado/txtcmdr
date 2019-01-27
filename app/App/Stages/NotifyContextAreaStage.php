<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderSendToArea;
use App\Campaign\Domain\Repositories\AreaRepository;

class NotifyContextAreaStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::SEND => CommanderSendToArea::class,
    ];

    protected function getNotifiable()
    {
        return optional($this->getArea(), function ($area) {
        	return $area->contacts()->where('id', '!=', $this->getCommander()->id)->get();
        });
    }

    protected function getArea()
    {
        $context = array_get($this->getParameters(), 'context');

        return $context 
               ? $this->getContextArea() 
               : $this->getCommander()->areas()->first()
               ;
    }

    protected function getContextArea()
    {
    	$context = array_get($this->getParameters(), 'context');

    	return app(AreaRepository::class)->findByField('name', $context)->first();
    }
}