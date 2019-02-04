<?php

namespace App\Campaign\Domain\Models;

use App\Missive\Domain\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use App\App\Traits\HasSchemalessAttributes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Checkin.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Checkin extends Model implements Transformable
{
    use TransformableTrait, HasSchemalessAttributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'longitude',
        'latitude',
        'location',
        'remarks',
	];

    public $casts = [
        'extra_attributes' => 'array',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function getMapUrlAttribute()
    {
        return $this->extra_attributes['map_url'];
    }

    public function setMapUrlAttribute($value)
    {
        $this->extra_attributes['map_url'] = $value;

        return $this;
    }
}
