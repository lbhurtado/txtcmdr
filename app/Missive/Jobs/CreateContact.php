<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\SMS;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class CreateContact
{
    use Dispatchable, Queueable;

    protected $sms;

    public function __construct(SMS $sms)
    {
        $this->sms = $sms;
    }

    public function handle(ContactRepository $contacts)
    {
        $mobile = $this->sms->from;

        $contacts->updateOrCreate(compact('mobile'));
    }
}
