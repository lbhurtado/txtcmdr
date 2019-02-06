<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderTagCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $campaign;

    public function __construct(Contact $commander, $campaign)
    {
        $this->commander = $commander;
        $this->campaign = $campaign;

        $this->onQueue('sms');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->commander->tags->setCampaign($this->campaign, true);
    }
}
