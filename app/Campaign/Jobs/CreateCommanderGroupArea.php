<?php

namespace App\Campaign\Jobs;

use Illuminate\Bus\Queueable;
use App\Missive\Domain\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Campaign\Domain\Models\{Area, Group};
use App\Missive\Domain\Repositories\ContactRepository;

class CreateCommanderGroupArea implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $area;
	
	protected $group;

	protected $mobile;

	protected $handle;

    public function __construct($mobile, $handle, $area = null, $group = null)
    {
        $this->area = $area;
        $this->group = $group;
        $this->mobile = $mobile;
        $this->handle = $handle;
    }

    public function handle(ContactRepository $contacts)
    {
    	$commander = $contacts->firstOrCreate([
    		'mobile' => $this->mobile,
    		'handle' => $this->handle,
    	]);

        $commander->syncAreas($this->area);
        $commander->syncGroups($this->group);
    }
}