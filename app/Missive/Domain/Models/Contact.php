<?php

namespace App\Missive\Domain\Models;

use App\App\Traits\HasNestedTrait;
use Spatie\ModelStatus\HasStatuses;
use App\App\Traits\HasNotifications;
use Illuminate\Database\Eloquent\Model;
use App\Missive\Domain\Contracts\Mobile;
use App\Campaign\Domain\Traits\SendsAlert;
use App\Campaign\Domain\Contracts\Polling;
use App\App\Traits\HasSchemalessAttributes;
use App\Charging\Domain\Traits\SpendsAirtime;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Campaign\Domain\Traits\{HasGroups, HasAreas, CanPollIssues, HasLocation, HasTags};

/**
 * Class Contact.
 *
 * @package namespace App\Missive\Domain\Models;
 */
class Contact extends Model implements Transformable, Mobile, Polling
{
    use TransformableTrait, SpendsAirtime, HasGroups, HasNotifications, HasAreas, HasTags, HasSchemalessAttributes, HasStatuses, SendsAlert, HasLocation, HasNestedTrait, CanPollIssues;

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
}
