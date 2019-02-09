<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Telerivet\Services\Telerivet;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TransferCommanderAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function handle(Telerivet $api)
    {
        $service = $api->getProject()->initServiceById($this->getServiceId());

        $service->invoke($this->getAttributes());
    }

    protected function getServiceId()
    {
        $default = config('txtcmdr.airtime.transfers.default');

        \Log::info('airtime transfer: ' . $default);

        return array_get(config('txtcmdr.airtime.transfers.telerivet.services'), $default);
    }

    protected function getAttributes()
    {
        return [
            'context' => 'contact',
            'contact_id' => $this->contact->telerivetId,
            'to_number' => $this->contact->mobile
        ];
    }
}
