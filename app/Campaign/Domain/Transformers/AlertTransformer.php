<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Alert;

/**
 * Class AlertTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class AlertTransformer extends TransformerAbstract
{
    /**
     * Transform the Alert entity.
     *
     * @param \App\Campaign\Domain\Models\Alert $model
     *
     * @return array
     */
    public function transform(Alert $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
