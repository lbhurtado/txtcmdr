<?php

namespace App\Missive\Domain\Listeners;

use League\Tactician\Middleware;
use Opis\Events\{Event, EventDispatcher};
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};

$dispatcher = new EventDispatcher();

class SMSEventSubscriber
{
	protected $dispatcher;

    public function onSMSCreated(SMSEvent $event)
    {        
		  	\Log::info('xxxxxxxxxxxxx');
    }

	public function __construct()
	{
		$this->dispatcher = new EventDispatcher();
	}

  //   public function execute($command, callable $next)
  //   {
  //   	$retval = $next($command);

		// $this->dispatcher->handle(SMSEvents::CREATED, function () {
		//   	\Log::info('xxxxxxxxxxxxx');
		// });

  //       return $retval;
  //   }

    public function subscribe($events)
    {

		$this->dispatcher->handle(SMSEvents::CREATED, function () {
		  	\Log::info('123');
		});
        // $events->listen(
        //     SMSEvents::CREATED, 
        //     SMSEventSubscriber::class.'@onSMSCreated'
        // );
    }
}