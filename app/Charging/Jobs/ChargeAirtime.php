<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Charging\Domain\Classes\AirtimeKey;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class ChargeAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $availment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($availment = AirtimeKey::SMS)
    {
        $this->availment = $availment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts, TextCommander $txtcmdr)
    {
        $mobile = $txtcmdr->sms->from;

        tap($contacts->findByField('mobile', $mobile)->first(), function ($origin) {
            $origin->spendAirtime($this->availment);
        }); 
    }
}
