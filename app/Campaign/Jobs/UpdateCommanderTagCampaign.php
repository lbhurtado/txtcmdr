<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;
use App\Campaign\Domain\Repositories\CampaignRepository;

class UpdateCommanderTagCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts, CampaignRepository $campaigns, TextCommander $txtcmdr)
    {
        optional($campaigns->findByField('name', $this->parameters['campaign'])->first(), function ($campaign) use ($contacts, $txtcmdr) {
            optional($contacts->findByField('mobile', $txtcmdr->sms->from)->first(), function($contact) use ($campaign) {
                optional($contact->tag, function ($tag) use ($campaign) {
                    $tag->setCampaign($campaign);                
                });
            });
        });
    }
}
