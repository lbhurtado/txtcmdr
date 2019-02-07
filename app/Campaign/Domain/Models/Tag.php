<?php

namespace App\Campaign\Domain\Models;

use App\Missive\Domain\Models\Contact;
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

//    public function tagger()
//    {
//        return $this->morphTo();
//    }

    public function tagger()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
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

    public function getOriginalCodeAttribute()
    {
        return $this->extra_attributes['original_code'];
    }

    public function setOriginalCodeAttribute($value)
    {
        $this->extra_attributes['original_code'] = $value;

        return $this;
    }

    public function groups()
    {
        return $this->morphedByMany(Group::class, 'taggable')->withTimestamps();
    }

    public function getGroupAttribute()
    {
        return $this->groups()->first();
    }

    public function areas()
    {
        return $this->morphedByMany(Area::class, 'taggable')->withTimestamps();
    }

    public function getAreaAttribute()
    {
        return $this->areas()->first();
    }

    public function campaigns()
    {
        return $this->morphedByMany(Campaign::class, 'taggable')->withTimestamps();
    }

    public function getCampaignAttribute()
    {
        return $this->campaigns()->first();
    }
}
