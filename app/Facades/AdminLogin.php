<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AdminLogin extends Facade
{
    protected static function getFacadeAccessor() { return 'adminLogin'; }
}
