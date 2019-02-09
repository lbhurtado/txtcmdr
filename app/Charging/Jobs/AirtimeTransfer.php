<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Telerivet\Services\Telerivet;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AirtimeTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function handle(Telerivet $api)
    {
        $service = $api->getProject()->initServiceById('SVa8cc328a77a0db75');

        $service->invoke($this->getAttributes());
    }

    protected function getAttributes()
    {
        return [
            'context' => 'contact',
            'contact_id' => $this->contact->telerivetId,
            'to_number' => $this->contact->mobile
        ];
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
