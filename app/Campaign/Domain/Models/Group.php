<?php

namespace App\Campaign\Domain\Models;

use Laravel\Scout\Searchable;
use App\App\Traits\HasNestedTrait;
use App\Missive\Domain\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use App\Campaign\Domain\Traits\HasAlerts;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Campaign\Domain\Contracts\CampaignContext;

/**
 * Class Group.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Group extends Model implements Transformable, CampaignContext
{
    use TransformableTrait, HasSchemalessAttributes, HasAlerts;

    use HasNestedTrait;
//    use Searchable {
//        Searchable::usesSoftDelete insteadof HasNestedTrait;
//    }

    protected $glue = ':';

    protected $pieces = 'title';

    protected $fillable = [
		'name',
        'alias'
    ];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    /**
     * Get all of the contacts that are assigned this group.
     */
    public function contacts()
    {
        return $this->morphedByMany(Contact::class, 'model', 'model_has_groups');
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'id' => $array['id'],
            'name' => $array['name'],
        ];
    }

    public function shouldBeSearchable()
    {
        return \App::environment('production');
    }
}
