<?php

namespace MCesar\Survey\Facade;

use Illuminate\Support\Facades\Facade;

class Question extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'question';
    }
}
