<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderUpline implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $tagger;

    public function __construct(Contact $commander, Contact $tagger)
    {
        $this->commander = $commander;
        $this->tagger = $tagger;
    }

    public function handle()
    {
        $this->commander->appendToNode($this->tagger)->save();
        $this->commander->upline()->associate($this->tagger)->save();
    }
}
