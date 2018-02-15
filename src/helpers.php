<?php

/**
 * @param string $guard
 *
 * @return string|null
 */
function isNotLumen() : bool
{
    return ! preg_match('/lumen/i', app()->version());
}
