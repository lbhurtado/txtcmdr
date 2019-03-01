<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Category;

/**
 * Class CategoryTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class CategoryTransformer extends TransformerAbstract
{
    /**
     * Transform the Category entity.
     *
     * @param \App\Campaign\Domain\Models\Category $model
     *
     * @return array
     */
    public function transform(Category $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
