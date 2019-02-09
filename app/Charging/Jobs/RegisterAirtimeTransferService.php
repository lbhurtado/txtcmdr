<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Telerivet\Services\Telerivet;
use Illuminate\Queue\SerializesModels;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RegisterAirtimeTransferService implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function handle(Telerivet $api)
    {
        $telerivet_id = $this->getTelerivetId($api);
        $this->contact->forceFill(compact('telerivet_id'))->save();
    }

    protected function getTelerivetId($api)
    {
        return $api->getProject()->getOrCreateContact($this->getAttributes())->id;
    }

    protected function getAttributes()
    {
        return [
            'phone_number' => $this->contact->mobile,
            'name' => $this->contact->handle,
        ];
    }
}
