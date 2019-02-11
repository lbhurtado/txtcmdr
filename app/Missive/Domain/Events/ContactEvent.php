<?php

namespace App\Missive\Domain\Events;

use Opis\Events\Event;
use App\Missive\Domain\Models\Contact;

class ContactEvent extends Event
{
    protected $contact;

    public function setContact(Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    public function getContact()
    {
        return $this->contact;
    }
}