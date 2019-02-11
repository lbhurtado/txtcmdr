<?php

namespace App\Missive\Domain\Observers;

use Opis\Events\EventDispatcher;
use App\Missive\Domain\Models\Contact;
use App\Missive\Domain\Events\{ContactEvent, ContactEvents};

class ContactObserver
{
    protected $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function created(Contact $contact)
    {
        tap(new ContactEvent(ContactEvents::CREATED), function (ContactEvent $event) use ($contact) {
            $this->dispatcher->dispatch($event->setContact($contact));
        });

    }

    public function updated(Contact $contact)
    {
        if ($contact->isDirty(['parent_id', '_lft', '_rgt'])) {
            tap($this->dispatcher, function($dispatcher) use ($contact) {
                tap(new ContactEvent(ContactEvents::ADOPTED), function (ContactEvent $event) use ($contact, $dispatcher) {
                    $dispatcher->dispatch($event->setContact($contact));
                });
            });
        }
    }
}
