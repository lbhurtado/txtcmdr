<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateContact
{
    use Dispatchable, Queueable;

    protected $contact;

    protected $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contact, $name)
    {
        $this->contact = $contact;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        tap($this->contact)->update(['name' => $this->name])->save();
    }
}
