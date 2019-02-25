<?php

namespace App\Campaign\Domain\Models;

use Laravel\Scout\Searchable;
use App\App\Traits\HasNestedTrait;
use App\Missive\Domain\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Campaign\Domain\Contracts\CampaignContext;
use App\Campaign\Domain\Models\AreaIssue as Pivot;

/**
 * Class Area.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Area extends Model implements Transformable, CampaignContext
{
    use TransformableTrait, HasSchemalessAttributes;
    use HasNestedTrait, Searchable {
        Searchable::usesSoftDelete insteadof HasNestedTrait;
    }

    protected $default = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
        'alias',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public $appends = [
        'name_suffixes',
    ];

    protected $guarded = ['_highlightResult'];

    /**
     * Get all of the contacts that are assigned this area.
     */
    public function contacts()
    {
        return $this->morphedByMany(Contact::class, 'model', 'model_has_areas');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'id' => $array['id'],
            'alias' => $array['alias'],
            'name' => $array['name'],
            'name_suffixes' => $array['name_suffixes'],
        ];
    }

    public function getNameSuffixesAttribute()
    {
        $array = [];

        $index = $this->attributes['name'];

        while (strpos($index, '0') === 0) {
            $index = substr($index,1);
            $array[] = $index;
        }

        return $array;
    }

    public function issues()
    {
        return $this->belongsToMany(Issue::class)
            ->withPivot('qty', 'contact_id')
            ->using(AreaIssue::class)
            ->withTimestamps();
    }

    public function addIssue(Issue $issue, Pivot $pivot)
    {
        return $this->issues()->attach($issue, $pivot->getAttributes());
    }
}
