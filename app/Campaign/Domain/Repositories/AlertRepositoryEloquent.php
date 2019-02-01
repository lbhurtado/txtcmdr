<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Repositories\AlertRepository;
use App\Campaign\Domain\Models\Alert;
use App\Campaign\Domain\Validators\AlertValidator;

/**
 * Class AlertRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class AlertRepositoryEloquent extends BaseRepository implements AlertRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Alert::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AlertValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
