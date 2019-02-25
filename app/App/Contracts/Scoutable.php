<?php
/**
 * Created by PhpStorm.
 * User: sofia
 * Date: 2019-02-21
 * Time: 13:10
 */

namespace App\App\Contracts;

interface Scoutable
{
    public function search($query = '', $callback = null);

    public function getSanitizedModel($input);
}
