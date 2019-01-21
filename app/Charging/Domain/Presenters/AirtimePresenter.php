<?php

namespace App\Charging\Domain\Presenters;

use App\Charging\Domain\Transformers\AirtimeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AirtimePresenter.
 *
 * @package namespace App\Charging\Domain\Presenters;
 */
class AirtimePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AirtimeTransformer();
    }
}
