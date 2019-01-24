<?php

namespace App\Missive\Jobs;

use Illuminate\Bus\Queueable;
use App\App\Services\TextCommander;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Campaign\Domain\Repositories\TagRepository;

class UpdateContact
{
    use Dispatchable, Queueable;

    protected $attributes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TagRepository $tags, TextCommander $txtcmdr)
    {
        tap($txtcmdr->commander())->update(array_only($this->attributes, 'name'))->save();
    }
}
