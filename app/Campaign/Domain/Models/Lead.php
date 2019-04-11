<?php

namespace App\Campaign\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Lead.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Lead extends Model implements Transformable
{
    use TransformableTrait, HasSchemalessAttributes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'extra_attributes',
    ];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function getAreaAttribute()
    {
        return $this->extra_attributes['area'];
    }

    public function getGroupAttribute()
    {
        return $this->extra_attributes['group'];
    }
}
