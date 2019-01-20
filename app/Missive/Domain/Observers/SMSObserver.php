<?php

namespace App\Missive\Domain\Observers;

use App\Missive\Domain\Models\SMS;
use Opis\Events\{Event,EventDispatcher};
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};

class SMSObserver
{
	protected $dispatcher;

	public function __construct()
	{
		$this->dispatcher = new EventDispatcher();

		$this->dispatcher->handle(SMSEvents::CREATED, function ($event) {
		  	\Log::info($event->getSMS());
		});
	}

    public function created(SMS $sms)
    {
    	tap($this->dispatcher, function($dispatcher) use ($sms) {
    		tap(new SMSEvent(SMSEvents::CREATED), function ($event) use ($sms, $dispatcher) {
    			$event->setSMS($sms);
    			$dispatcher->dispatch($event);
    		});			
    	});
    }
}
