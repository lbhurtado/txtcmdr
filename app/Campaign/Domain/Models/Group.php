<?php

namespace App\Campaign\Domain\Models;

use App\App\Traits\HasNestedTrait;
use App\Missive\Domain\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Group.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Group extends Model implements Transformable
{
    use TransformableTrait, HasNestedTrait, HasSchemalessAttributes;

    protected $glue = ':';

    protected $pieces = 'title';

    protected $fillable = [
		'name',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    /**
     * Get all of the contacts that are assigned this area.
     */
    public function contacts()
    {
        return $this->morphedByMany(Contact::class, 'model', 'model_has_groups');
    }
}
