<?php

namespace App\Campaign\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Stub.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Stub extends Model implements Transformable
{
    use TransformableTrait, HasSchemalessAttributes, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
