<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\StubTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StubPresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class StubPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StubTransformer();
    }
}
