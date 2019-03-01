<?php

namespace App\Campaign\Domain\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

use App\Campaign\Domain\Models\Area;
use App\Campaign\Domain\Models\AreaIssue as Pivot;

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

    public function areas()
    {
        return $this->belongsToMany(Area::class)
            ->withPivot('qty', 'contact_id')
            ->using(Pivot::class)
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
