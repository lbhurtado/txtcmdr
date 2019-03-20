<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\SMS;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Charging\Domain\Classes\AirtimeKey;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChargeAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //properties are public for testing purposes
    public $sms;

    public $availment;

    public function __construct(SMS $sms, $availment = AirtimeKey::INCOMING_SMS)
    {
        $this->sms = $sms;
        $this->availment = $availment;
    }

    public function handle()
    {
        $this->sms->origin->spendAirtime($this->availment);
    }
}
