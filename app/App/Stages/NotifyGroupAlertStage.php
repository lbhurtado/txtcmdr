<?php

namespace App\App\Stages;

use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Classes\CommandKey;
use App\Campaign\Notifications\CommanderAlertToGroup;

class NotifyGroupAlertStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::ALERT => CommanderAlertToGroup::class,
    ];

    protected function getNotifiable()
    {
		return Contact::whereHas('groups', function ($query) {
            $query->whereHas('alerts', function ($q) {
                $q->where('name', $this->getInputAlert());
            });
        })->get();
    }

    protected function getInputAlert()
    {
    	return array_get($this->getParameters(), 'alert');
    }

    public function setup($key)
    {
        $this->params = ['whistleBlower' => $this->getCommander()];
    }
}
