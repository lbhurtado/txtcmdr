<?php

namespace App\Missive\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Missive\Domain\Contracts\Mobile;
use App\Charging\Domain\Traits\SpendsAirtime;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Missive\Domain\Contracts\MobileInterface;
/**
 * Class Contact.
 *
 * @package namespace App\Missive\Domain\Models;
 */
class Contact extends Model implements Transformable, Mobile
{
    use TransformableTrait, SpendsAirtime;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'mobile',
		'name',
	];

}
