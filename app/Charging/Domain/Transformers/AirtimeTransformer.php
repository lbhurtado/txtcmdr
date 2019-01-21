<?php

namespace App\Charging\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Charging\Domain\Models\Airtime;

/**
 * Class AirtimeTransformer.
 *
 * @package namespace App\Charging\Domain\Transformers;
 */
class AirtimeTransformer extends TransformerAbstract
{
    /**
     * Transform the Airtime entity.
     *
     * @param \App\Charging\Domain\Models\Airtime $model
     *
     * @return array
     */
    public function transform(Airtime $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
