<?php

namespace Vormkracht10\FilamentMails\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vormkracht10\FilamentMails\FilamentMails
 */
class FilamentMails extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vormkracht10\FilamentMails\FilamentMails::class;
    }
}
