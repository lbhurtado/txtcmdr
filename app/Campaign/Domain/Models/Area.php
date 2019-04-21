<?php

namespace App\Campaign\Domain\Models;

use Laravel\Scout\Searchable;
use App\App\Traits\HasNestedTrait;
use App\Missive\Domain\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use App\Campaign\Domain\Traits\HasIssues;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Campaign\Domain\Contracts\CampaignContext;
use App\Campaign\Domain\Models\AreaIssue as Pivot;
//use Tightenco\Parental\HasChildren;
//use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

/**
 * Class Area.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Area extends Model implements Transformable, CampaignContext
{
    use TransformableTrait, HasSchemalessAttributes, HasIssues;
    use HasNestedTrait;
//    use Searchable {
//        Searchable::usesSoftDelete insteadof HasNestedTrait;
//    }
//    use HasChildren;
//    use SingleTableInheritanceTrait {
//        newFromBuilder as stiNewFromBuilder;
//    }
//
//    public function newFromBuilder($attributes = array(), $connection = null)
//    {
//        $instance = $this->stiNewFromBuilder($attributes, $connection);
//        $instance->clearAction();
//
////        return $instance;
//    }

//    protected $table = "areas";
//
//    protected static $singleTableTypeField = 'type';
//
//    protected static $singleTableSubclasses = [
//        \App\Campaign\Domain\Models\Inheritors\District::class,
//        \App\Campaign\Domain\Models\Inheritors\Town::class,
//    ];

//    protected $childTypes = [
//        'district' => \App\Campaign\Domain\Models\Inheritors\District::class,
//        'town' => \App\Campaign\Domain\Models\Inheritors\Town::class,
//    ];

//    public const PRECINCT = 'precinct';
//
//    public const CLUSTER = 'cluster';
//
//    public const BARANGAY = 'barangay';
//
//    public const TOWN = 'town';
//
//    public const DISTRICT = 'district';

    protected $default = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
        'alias',
        'type'
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

    public function getRegisteredVotersAttribute()
    {
        return (int) $this->extra_attributes['registered_voters'];
    }

    public function shouldBeSearchable()
    {
        return \App::environment('production');
    }
}
