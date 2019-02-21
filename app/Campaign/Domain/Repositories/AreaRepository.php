<?php

namespace App\Campaign\Domain\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AreaRepository.
 *
 * @package namespace App\Campaign\Domain\Repositories;
 */
interface AreaRepository extends RepositoryInterface
{
    public function search($query = '', $callback = null);
}
