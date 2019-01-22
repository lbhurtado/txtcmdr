<?php

namespace App\Campaign\Domain\Models;

use App\App\Traits\HasNestedTrait;
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
}
