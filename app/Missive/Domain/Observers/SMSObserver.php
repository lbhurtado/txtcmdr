<?php

namespace App\Missive\Domain\Observers;

use Opis\Events\EventDispatcher;
use App\Missive\Domain\Models\SMS;
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};

class SMSObserver
{
	protected $dispatcher;

	public function __construct(EventDispatcher $dispatcher)
	{
        $this->dispatcher = $dispatcher;
	}

    public function created(SMS $sms)
    {
    	tap($this->dispatcher, function($dispatcher) use ($sms) {
    		tap(new SMSEvent(SMSEvents::CREATED), function (SMSEvent $event) use ($sms, $dispatcher) {
    			$dispatcher->dispatch($event->setSMS($sms));
    		});			
    	});
    }
}
