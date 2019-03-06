<?php

namespace App\Campaign\Domain\Observers;

use App\Campaign\Domain\Models\Area;

class AreaObserver
{
    /**
     * Handle the area "creating" event.
     *
     * @param  \App\App\Campaign\Domain\Models\Area  $area
     * @return void
     */
    public function creating(Area $area)
    {
        $original_name = $area->name;

        $area->name = optional(strstr($area->name, ':', true) ?: null, function ($name) use ($area, $original_name) {
             $area->extra_attributes['original_name'] = $original_name;

             return $name;
        }) ?? $original_name;
    }
}
