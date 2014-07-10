<?php namespace Efficiently\JqueryLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class HTMLEloquentHelper extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'html_eloquent_helper';
    }
}
