<?php

namespace App\Campaign\Domain\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Issue.
 *
 * @package namespace App\Campaign\Domain\Models;
 */
class Issue extends Model implements Transformable
{
    use TransformableTrait, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return [
            'id' => $array['id'],
            'code' => $array['code'],
            'name' => $array['name'],
        ];
    }
}
