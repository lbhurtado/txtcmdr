<?php

namespace App\Campaign\Jobs\Charge;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Charging\Domain\Classes\AirtimeKey;

class ChargeCommanderOutgoingSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commander;

    public function __construct(Contact $commander)
    {
        $this->commander = $commander;
    }

    public function handle()
    {
        $this->commander->spendAirtime(AirtimeKey::OUTGOING_SMS);
    }
}
