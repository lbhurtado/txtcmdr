<?php

namespace App\Missive\Domain\Models;

use Spatie\ModelStatus\HasStatuses;
use App\App\Traits\HasNotifications;
use Illuminate\Database\Eloquent\Model;
use App\Missive\Domain\Contracts\Mobile;
use App\App\Traits\HasSchemalessAttributes;
use App\Charging\Domain\Traits\SpendsAirtime;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Missive\Domain\Contracts\MobileInterface;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Campaign\Domain\Traits\{HasGroups, HasAreas, HasTags};

/**
 * Class Contact.
 *
 * @package namespace App\Missive\Domain\Models;
 */
class Contact extends Model implements Transformable, Mobile
{
    use TransformableTrait, SpendsAirtime, HasGroups, HasNotifications, HasAreas, HasTags, HasSchemalessAttributes, HasStatuses;

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
    public function upline(): MorphTo
    {
        return $this->morphTo();
    }

    public function downlines()
    {
        return $this->morphOne(Contact::class, 'upline');
    }
}
