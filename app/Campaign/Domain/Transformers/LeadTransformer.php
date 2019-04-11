<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Lead;

/**
 * Class LeadTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class LeadTransformer extends TransformerAbstract
{
    /**
     * Transform the Lead entity.
     *
     * @param \App\Campaign\Domain\Models\Lead $model
     *
     * @return array
     */
    public function transform(Lead $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
