<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class CreateContact
{
    use Dispatchable, Queueable;

    protected $mobile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts)
    {
        $contacts->updateOrCreate(['mobile' => $this->mobile]);
    }
}