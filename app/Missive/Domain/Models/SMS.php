<?php

namespace App\Missive\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SMS extends Model implements Transformable
{
    use TransformableTrait;
    
    protected $fillable = [
    	'from',
    	'to',
    	'message',
    ];
}
