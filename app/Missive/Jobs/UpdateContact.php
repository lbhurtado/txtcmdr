<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contact;

    public $handle;

    public function __construct(Contact $contact, $handle)
    {
        $this->contact = $contact;
        $this->handle = $handle;
        $this->onQueue('sms');
    }

    public function handle()
    {
        $this->contact->update(['handle' => $this->handle]);
    }
}
