<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class UpdateContactGroup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts, TextCommander $txtcmdr)
    {
        $mobile = $txtcmdr->sms->from;

        tap($contacts->findByField('mobile', $mobile)->first(), function($contact) {
            $contact->syncGroups($this->parameters['group']);
        });
    }
}
