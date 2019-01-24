<?php

namespace App\Campaign\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Campaign.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Campaign extends Model implements Transformable
{
    use TransformableTrait, HasSchemalessAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'message',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];
}
