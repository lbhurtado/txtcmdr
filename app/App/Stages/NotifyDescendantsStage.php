<?php

namespace App\App\Stages;

use Illuminate\Support\Arr;
use App\Missive\Domain\Models\Contact;
use App\Campaign\Domain\Classes\{Command, CommandKey};
use App\Campaign\Notifications\DescendantsBroadcastUpdated;

class NotifyDescendantsStage extends NotifyStage
{
    protected $notifications = [
        CommandKey::BROADCAST => DescendantsBroadcastUpdated::class,
    ];

    protected function getNotifiable()
    {
//        return Contact::all();
        return $this->getCommander()->descendants()->get();
    }

    public function setup($key)
    {
        $this->params = [
            'message' => Arr::get($this->getParameters(), 'message'),
            'origin' => $this->getCommander(),
        ];
    }
}
