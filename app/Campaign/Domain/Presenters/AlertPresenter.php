<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\AlertTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AlertPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class AlertPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AlertTransformer();
    }
}
