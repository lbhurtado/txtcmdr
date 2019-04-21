<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Campaign\Domain\Models\Lead;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderLead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $commander;

    public $lead;

    public function __construct(Contact $commander, Lead $lead)
    {
        $this->commander = $commander;
        $this->lead = $lead;

        $this->onQueue('sms');
    }

    public function handle()
    {
        $this->commander->extra_attributes['name'] = $this->lead->name;
        $this->commander->extra_attributes['area'] = $this->lead->extra_attributes['area'];
        $this->commander->extra_attributes['group'] = $this->lead->extra_attributes['group'];
        $this->commander->save();
    }
}
