<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
// use App\Missive\Domain\Repositories\ContactRepository;

class UpdateCommanderTag implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $code;

    protected $originalCode;

    // *
    //  * Create a new job instance.
    //  *
    //  * @return void
     
    public function __construct($code, $originalCode = null)
    {
        $this->code = $code;
        $this->originalCode = $originalCode ?? $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TextCommander $txtcmdr)
    {
        tap($txtcmdr->commander()->syncTag($this->code), function ($tag) {
            $tag->originalCode = $this->originalCode;
        })->save();
    }
}
