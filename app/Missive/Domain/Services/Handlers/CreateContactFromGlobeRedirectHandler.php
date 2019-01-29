<?php

namespace App\Missive\Domain\Services\Handlers;

use App\App\CommandBus\Contracts\HandlerInterface;
use App\App\CommandBus\Contracts\CommandInterface;
use App\Missive\Domain\Repositories\ContactRepository;

class CreateContactFromGlobeRedirectHandler implements HandlerInterface
{
	protected $contacts;

    public function __construct(ContactRepository $contacts)
    {
    	$this->contacts = $contacts;
    }

    public function handle(CommandInterface $command)
    {
        $mobile = $command->subscriber_number;

        tap($this->contacts->updateOrCreate(compact('mobile')), function ($contact) use ($command) {
            $contact->token = $command->access_token;
        })->save();
    }
}
