<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderArea implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TextCommander $txtcmdr)
    {
        $txtcmdr->commander()->syncAreas($this->parameters['area']);
    }
}
