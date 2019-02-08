<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Telerivet\Services\Telerivet;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class AirtimeTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobile;

    public function __construct($mobile)
    {
        $this->mobile = $mobile;
    }

    public function handle(Telerivet $api)
    {
        $service = $api->getProject()->initServiceById('SVa8cc328a77a0db75');

        $service->invoke([
            'context' => 'contact',
            'to_number' => $this->mobile,
        ]);
    }
//
//    protected function getArguments()
//    {
//        $retval['context'] = 'contact';
//        $retval['content'] = $this->message->content;
//        $telerivet_id = $this->contact->routeNotificationFor('telerivet');
//        if ($telerivet_id)
//            $retval['contact_id'] = $telerivet_id;
//        $retval['to_number'] = $this->contact->mobile;
//
//        return $retval;
//    }
}
