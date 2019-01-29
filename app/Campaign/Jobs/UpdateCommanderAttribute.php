<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommanderAttribute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commander;

    protected $key;

    protected $value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contact $commander, $key, $value)
    {
        $this->commander = $commander;
        $this->key       = $key;
        $this->value     = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        tap($this->commander, function ($commander) {
            $commander->extra_attributes->set($this->key, $this->value);
        })->save();
    }
}
