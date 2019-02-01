<?php

namespace App\Campaign\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
/**
 * Class Alert.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Alert extends Model implements Transformable
{
    use TransformableTrait, HasSchemalessAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];
}
