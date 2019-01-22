<?php

namespace App\App\Facades;

use Illuminate\Support\Facades\Facade;

class TxtCmdr extends Facade
{
    protected static function getFacadeAccessor()
    { 
    	return 'txtcmdr'; 
    }
}