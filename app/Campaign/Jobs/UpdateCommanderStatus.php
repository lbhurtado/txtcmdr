<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $status;

    protected $reason;

    public function __construct(Contact $commander, $status, $reason = null)
    {
        $this->commander = $commander;
        $this->status    = $status;
        $this->reason    = $reason;
    }

    public function handle()
    {
        $this->commander->setStatus($this->status, $this->reason);
    }
}
