<?php

namespace App\Campaign\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Tag.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Tag extends Model implements Transformable
{
    use TransformableTrait, HasSchemalessAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'code',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function tagger()
    {
        return $this->morphTo();
    }

    public function setGroup(Group $group, $detach = false)
    {
        if ($detach == true) {
            $this->groups()->detach();
        }

        $this->groups()->save($group);

        return $this;
    }

    public function setArea(Area $area, $detach = false)
    {
        if ($detach == true) {
            $this->areas()->detach();
        }

        $this->areas()->save($area);

        return $this;
    }

    public function setCampaign(Campaign $campaign, $detach = false)
    {
        if ($detach == true) {
            $this->campaigns()->detach();
        }
        
        $this->campaigns()->save($campaign);

        return $this;
    }
    
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'taggable')->withTimestamps();
    }

    public function areas()
    {
        return $this->morphedByMany(Area::class, 'taggable')->withTimestamps();
    }

    public function campaigns()
    {
        return $this->morphedByMany(Campaign::class, 'taggable')->withTimestamps();
    }
}
