<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateContact
{
    use Dispatchable, Queueable;

    protected $contact;

    protected $handle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contact, $handle)
    {
        $this->contact = $contact;
        $this->handle = $handle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        tap($this->contact)->update(['handle' => $this->handle])->save();
    }
}
