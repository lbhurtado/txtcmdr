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
        $phone_number = $this->contact->mobile;
        $name = $this->contact->handle;
        $telerivet_id = $api->getProject()->getOrCreateContact(compact('phone_number', 'name'))->id;
        $this->contact->forceFill(compact('telerivet_id'))->save();
    }

    protected function getTelerivetContact($mobile, $handle)
    {
        return $this->getTelerivetProject()->getOrCreateContact([
            'phone_number' => $mobile,
            'name' => $handle,
        ]);
    }

    protected function getTelerivetProject()
    {
        $config = config('broadcasting.connections.telerivet');

        return (new Telerivet($config['api_key'], $config['project_id'], $config['service_id']))->getProject();
    }
}
