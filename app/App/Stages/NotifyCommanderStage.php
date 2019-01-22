<?php

namespace App\App\Stages;

use League\Pipeline\StageInterface;
use App\App\Services\TextCommander;
use App\Campaign\Notifications\ContactGroupUpdated;

class NotifyCommanderStage implements StageInterface
{
	protected $txtcmdr;

	protected $contacts;

	// public function __construct(TextCommander $txtcmdr, ContactRepository $contacts)
	// {
	// 	$this->txtcmdr = $txtcmdr;
	// }

    public function __invoke($parameters)
    {
    	$this->getContact()->notify(new ContactGroupUpdated());

    	\Log::info('NotifyCommanderStage::__invoke');
    	\Log::info($parameters);

    	return $parameters;
    }

    protected function getContact()
    {
    	return \App\Missive\Domain\Models\Contact::first();

    	$mobile = $this->txtcmdr->sms->from;

    	return $contacts->findByField('mobile', $mobile)->first();
    }
}