<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Missive\Domain\Repositories\ContactRepository;

class UpdateContact
{
    use Dispatchable, Queueable;

    protected $mobile;

    protected $name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile, $name)
    {
        $this->mobile = $mobile;
        $this->name = $name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContactRepository $contacts)
    {
        $contacts->updateOrCreate(['mobile' => $this->mobile], ['name' => $this->name]);
    }
}
