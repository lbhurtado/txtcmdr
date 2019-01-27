<?php

namespace App\App\Stages;

use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderSendToGroup;
use App\Campaign\Domain\Repositories\GroupRepository;

class NotifyContextGroupStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::SEND => CommanderSendToGroup::class,
    ];

    protected function getNotifiable()
    {
        return optional($this->getGroup(), function ($group) {
        	return $group->contacts()->where('id', '!=', $this->getCommander()->id)->get();
        });
    }
    
    protected function getGroup()
    {
        $context = array_get($this->getParameters(), 'context');

        return $context 
               ? $this->getContextGroup() 
               : $this->getCommander()->groups()->first()
               ;
    }

    protected function getContextGroup()
    {
    	$context = array_get($this->getParameters(), 'context');

    	return app(GroupRepository::class)->findByField('name', $context)->first();
    }
}