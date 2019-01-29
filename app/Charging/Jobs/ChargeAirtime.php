<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\SMS;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Charging\Domain\Classes\AirtimeKey;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;



class ChargeAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sms;

    protected $availment;

    public function __construct(SMS $sms, $availment = AirtimeKey::SMS)
    {
        $this->sms = $sms;
        $this->availment = $availment;
    }

    public function handle(ContactRepository $contacts)
    {
        $mobile = $this->sms->from;

        tap($contacts->findByField(compact('mobile'))->first(), function ($origin) {
            $origin->spendAirtime($this->availment);
        }); 
    }
}
