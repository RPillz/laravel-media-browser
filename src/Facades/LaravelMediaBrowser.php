<?php

namespace RPillz\LaravelMediaBrowser\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RPillz\LaravelMediaBrowser\LaravelMediaBrowser
 */
class LaravelMediaBrowser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RPillz\LaravelMediaBrowser\LaravelMediaBrowser::class;
    }
}
