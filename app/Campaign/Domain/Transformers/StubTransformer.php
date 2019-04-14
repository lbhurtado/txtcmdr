<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Stub;

/**
 * Class StubTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class StubTransformer extends TransformerAbstract
{
    /**
     * Transform the Stub entity.
     *
     * @param \App\Campaign\Domain\Models\Stub $model
     *
     * @return array
     */
    public function transform(Stub $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
