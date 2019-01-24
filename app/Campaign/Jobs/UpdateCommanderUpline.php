<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Campaign\Domain\Repositories\TagRepository;
use App\Missive\Domain\Repositories\ContactRepository;


class UpdateCommanderUpline implements ShouldQueue
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
    public function handle(TagRepository $tags, TextCommander $txtcmdr)
    {
        optional($tags->findByField('code', array_get($this->parameters, 'tag'))->first(), function ($tag) use ($txtcmdr) {
            $txtcmdr->commander()->upline()->associate($tag->tagger)->save();
        });
    }
}
