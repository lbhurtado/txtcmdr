<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Area;

/**
 * Class AreaTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class AreaTransformer extends TransformerAbstract
{
    /**
     * Transform the Area entity.
     *
     * @param \App\Campaign\Domain\Models\Area $model
     *
     * @return array
     */
    public function transform(Area $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
