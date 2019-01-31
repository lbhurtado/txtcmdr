<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateContact
{
    use Dispatchable, Queueable;

    protected $contact;

    protected $handle;

    public function __construct(Contact $contact, $handle)
    {
        $this->contact = $contact;
        $this->handle = $handle;
    }

    public function handle()
    {
        $handle = $this->handle;

        tap($this->contact)->update(compact('handle'))->save();
    }
}
