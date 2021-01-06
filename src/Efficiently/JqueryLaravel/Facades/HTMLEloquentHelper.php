<?php

namespace Efficiently\JqueryLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Efficiently\JqueryLaravel\EloquentHtmlHelper
 */
class HTMLEloquentHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'html_eloquent_helper';
    }
}
