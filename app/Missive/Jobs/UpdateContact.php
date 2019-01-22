<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class UpdateContact
{
    use Dispatchable, Queueable;

    protected $attributes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts, TextCommander $txtcmdr)
    {
        $contacts->updateOrCreate([
            'mobile' => $txtcmdr->sms->from
        ], [
            'name' => $this->attributes['name']
        ]);
    }
}
