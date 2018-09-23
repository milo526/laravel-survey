<?php

namespace MCesar\Survey\Facade;

use Illuminate\Support\Facades\Facade;

class Category extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'category';
    }
}
