<?php

namespace YourNamespace\AppSumo\Facades;

use Illuminate\Support\Facades\Facade;

class AppSumo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'appsumo';
    }
}
