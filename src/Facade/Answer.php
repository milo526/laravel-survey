<?php

namespace MCesar\Survey\Facade;

use Illuminate\Support\Facades\Facade;

class Answer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'answer';
    }
}
