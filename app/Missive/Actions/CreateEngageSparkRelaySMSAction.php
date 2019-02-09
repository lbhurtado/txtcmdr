<?php

namespace App\Missive\Actions;

use App\App\Facades\TxtCmdr;
use App\App\Jobs\ProcessCommand;
use App\Missive\Jobs\CreateContact;
use App\Charging\Jobs\ChargeAirtime;
use App\Missive\{
        Responders\CreateSMSResponder,
        Domain\Validators\CreateEngageSparkSMSValidator,
        Domain\Services\Handlers\CreateSMSHandler,
        Domain\Services\Commands\CreateEngageSparkSMSCommand
};
use App\Missive\Domain\Events\{SMSEvent, SMSEvents};
use App\App\CommandBus\Contracts\{ActionInterface, ActionAbstract};

class CreateEngageSparkRelaySMSAction extends ActionAbstract implements ActionInterface
{
    protected $fields = ['secret', 'from', 'to', 'message'];

    protected $command = CreateEngageSparkSMSCommand::class;

    protected $handler = CreateSMSHandler::class;

    protected $middlewares = [
//        CreateEngageSparkSMSValidator::class,
        CreateSMSResponder::class,
    ];

    public function setup()
    {
        $this->getDispatcher()->handle(SMSEvents::CREATED, function (SMSEvent $event) {
            tap($event->getSMS(), function ($sms) {

                TxtCmdr::setSMS($sms);

                $this->dispatchNow(new CreateContact($sms));
                $this->dispatchNow(new ProcessCommand());
                $this->dispatch(new ChargeAirtime($sms));
            });
        });
    }
}
