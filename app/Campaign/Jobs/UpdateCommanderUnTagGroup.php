<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderUnTagGroup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    public function __construct(Contact $commander)
    {
        $this->commander = $commander;

        $this->onQueue('sms');
    }

    public function handle()
    {
        $this->commander->tag->groups()->detach();
    }
}
