<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Repositories\CheckinRepository;
use App\Campaign\Domain\Models\Checkin;
use App\Campaign\Domain\Validators\CheckinValidator;

/**
 * Class CheckinRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class CheckinRepositoryEloquent extends BaseRepository implements CheckinRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Checkin::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CheckinValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
