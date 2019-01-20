<?php

namespace App\Missive\Domain\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Missive\Domain\Repositories\SMSRepository;
use App\Missive\Domain\Models\SMS;
// use App\Validators\App\Missive\Domain\Models\SMSValidator;

class SMSRepositoryEloquent extends BaseRepository implements SMSRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SMS::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}