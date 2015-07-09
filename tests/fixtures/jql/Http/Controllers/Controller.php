<?php namespace Jql\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;
    use \Efficiently\JqueryLaravel\ControllerAdditions;

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'app';
}
