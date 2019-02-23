<?php

namespace App\Campaign\Domain\Presenters;

use App\Campaign\Domain\Transformers\IssueTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class IssuePresenter.
 *
 * @package namespace App\Campaign\Domain\Presenters;
 */
class IssuePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new IssueTransformer();
    }
}
