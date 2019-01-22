<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class CreateContact
{
    use Dispatchable, Queueable;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts, TextCommander $txtcmdr)
    {
        $contacts->updateOrCreate(['mobile' => $txtcmdr->sms->from]);
    }
}
