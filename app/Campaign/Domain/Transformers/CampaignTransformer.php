<?php

namespace App\Campaign\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Campaign\Domain\Models\Campaign;

/**
 * Class CampaignTransformer.
 *
 * @package namespace App\Campaign\Domain\Transformers;
 */
class CampaignTransformer extends TransformerAbstract
{
    /**
     * Transform the Campaign entity.
     *
     * @param \App\Campaign\Domain\Models\Campaign $model
     *
     * @return array
     */
    public function transform(Campaign $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
