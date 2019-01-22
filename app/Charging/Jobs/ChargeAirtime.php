<?php

namespace App\Charging\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\SMS;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
// use App\Charging\Domain\Classes\AirtimeKey;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class ChargeAirtime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sms;

    protected $contacts;

    protected $availment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SMS $sms, $availment)
    {
        $this->sms = $sms;
        $this->availment = $availment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts)
    {
        $this->contacts = $contacts;

        tap($this->getOrigin(), function ($origin) {
            $origin->spendAirtime($this->availment);
        });
    }

    protected function getOrigin():Contact
    {
        $mobile = $this->sms->from;

        return $this->contacts->findByField('mobile', $mobile)->first();
    }
}
