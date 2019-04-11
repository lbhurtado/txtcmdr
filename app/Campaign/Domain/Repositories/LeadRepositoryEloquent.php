<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Campaign\Domain\Repositories\LeadRepository;
use App\Campaign\Domain\Models\Lead;
use App\Campaign\Domain\Validators\LeadValidator;

/**
 * Class LeadRepositoryEloquent.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
class LeadRepositoryEloquent extends BaseRepository implements LeadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lead::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return LeadValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
