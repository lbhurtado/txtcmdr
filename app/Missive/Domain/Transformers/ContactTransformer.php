<?php

namespace App\Missive\Domain\Transformers;

use League\Fractal\TransformerAbstract;
use App\Missive\Domain\Models\Contact;

/**
 * Class ContactTransformer.
 *
 * @package namespace App\Missive\Domain\Transformers;
 */
class ContactTransformer extends TransformerAbstract
{
    /**
     * Transform the Contact entity.
     *
     * @param \App\Missive\Domain\Models\Contact $model
     *
     * @return array
     */
    public function transform(Contact $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
