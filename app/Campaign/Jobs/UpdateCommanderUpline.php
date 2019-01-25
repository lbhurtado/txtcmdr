<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderUpline implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tagger;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tagger)
    {
        $this->tagger = $tagger;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TextCommander $txtcmdr)
    {
        $txtcmdr->commander()->upline()->associate($this->tagger)->save();
    }
}
