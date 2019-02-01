<?php

namespace App\Campaign\Domain\Models;

use App\Campaign\Domain\Models\Group;
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

    /**
     * Get all of the contacts that are assigned this area.
     */
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'model', 'model_has_alerts');
    }
}
