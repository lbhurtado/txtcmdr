<?php

namespace App\Campaign\Observers;

use Opis\Events\EventDispatcher;
use App\Campaign\Domain\Models\Checkin;
use App\Campaign\Domain\Events\{CheckinEvent, CheckinEvents};

class CheckinObserver
{
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function created(Checkin $checkin)
    {
        tap(new CheckinEvent(CheckinEvents::CREATED), function (CheckinEvent $event) use ($checkin) {
            $this->dispatcher->dispatch($event->setCheckin($checkin));
        });

    }
}