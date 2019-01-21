<?php

namespace App\Charging\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Charging\Domain\Repositories\AirtimeRepository;
use App\Charging\Domain\Models\Airtime;
use App\Charging\Domain\Validators\AirtimeValidator;

/**
 * Class AirtimeRepositoryEloquent.
 *
 * @package namespace App\Charging\Domain\Repositories;
 */
class AirtimeRepositoryEloquent extends BaseRepository implements AirtimeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Airtime::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AirtimeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
