<?php

namespace App\Missive\Domain\Models;

use App\Campaign\Domain\Contracts\CanPoll;
use App\Campaign\Domain\Models\AreaIssue;
use App\Campaign\Domain\Repositories\IssueRepository;
use Spatie\ModelStatus\HasStatuses;
use App\App\Traits\HasNotifications;
use Illuminate\Database\Eloquent\Model;
use App\Missive\Domain\Contracts\Mobile;
use App\Campaign\Domain\Traits\SendsAlert;
use App\App\Traits\HasSchemalessAttributes;
use App\Charging\Domain\Traits\SpendsAirtime;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Campaign\Domain\Traits\{HasGroups, HasAreas, HasLocation, HasTags};

use App\App\Traits\HasNestedTrait;
use App\Campaign\Domain\Models\Issue;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Class Contact.
 *
 * @package namespace App\Missive\Domain\Models;
 */
class Contact extends Model implements Transformable, Mobile, CanPoll
{
    use TransformableTrait, SpendsAirtime, HasGroups, HasNotifications, HasAreas, HasTags, HasSchemalessAttributes, HasStatuses, SendsAlert, HasLocation, HasNestedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'mobile',
		'handle',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];
    
    public $appends = [
        'token',
    ];

    public function adopt(Contact $child)
    {
        $child->appendToNode($this)->save();
    }

    public function getMobileHandleAttribute()
    {
        return string($this->handle)->concat(' [')->concat($this->mobile)->concat(']');
    }

    public function issues()
    {
        return $this->belongsToMany(Issue::class)->withPivot(['qty'])->withTimestamps();
    }

    public function poll($issue_code, $qty)
    {
        optional($this->areas()->first(), function ($area) use ($issue_code, $qty) {
            $pivot = AreaIssue::conjure($this, $qty);
            optional(app(IssueRepository::class)->getSanitizedModel($issue_code), function ($issue) use ($area, $pivot) {
                return $area->addIssue($issue, $pivot);
           });
        });

        return $this;
    }
}
