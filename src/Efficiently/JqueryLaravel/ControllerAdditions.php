<?php namespace Efficiently\JqueryLaravel;

use View;
use Request;
use Response;

trait ControllerAdditions
{

    /**
     * @param  \Illuminate\View\View|string|array $view View object or view path
     * @param  array $data Data that should be made available to the view. Only used when $view is a string path
     * @param  string|boolean $layout Master layout path
     *
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function render($view, $data = [], $layout = null)
    {
        $format = null;

        if (is_array($view) && count($view) === 1) {
            $format = array_keys($view)[0];
            $view = array_values($view)[0];
            if (! ends_with($view, '_'.$format)) {
                $view = $view.'_'.$format;
            }
        }

        if (is_string($view)) {
            $view = View::make($view, $data);
        }

        // short circuit
        if ($format) {
            $response = Response::make($view);
            $response->header('Content-Type', Request::getMimeType($format));

            return $response;
        }

        if (! is_null($layout)) {
            $this->layout = $layout;
            $this->setupLayout();
        }

        if ($this->layout) {
            $this->layout->content = $view;

            return $this->layout;
        } else {
            return $view;
        }
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout) && $this->layout !== false) {
            $this->layout = View::make($this->layout);
        }
    }
}

// Use case:
/*
class UsersController extends \Controller
{
    use Efficiently\JqueryLaravel\ControllerAdditions;

    // Set your layout name, if any, here:
    // See: http://laravel.com/docs/templates#controller-layouts
    // protected $layout = 'layouts.master';

    //...

    // Display a listing of the user resource
    public function index()
    {
        $this->users = User::all();

        $format = Request::format();

        switch ($format) {
            case 'html':
                $render = $this->render('users.index', compact_property($this, 'users'));
                break;
            case 'js' :
                // PROTIPS: in a HTML view try: {{ link_to_route("users.index", "List all users", [], ["data-remote" => true]) }}
                // NOTICE: You need to create a 'app/views/users/index_js.blade.php' file
                $render = $this->render(['js' => 'users.index'], compact_property($this, 'users'));
                break;
            case 'json':
                // PROTIPS: In a JavaScript console try: $.getJSON("/users", function(data) { console.log(JSON.stringify(data)); });
                // return $this->users; // no blade view

                // NOTICE: You need to create a 'app/views/users/index_json.blade.php' file
                $render = $this->render(['json' => 'users.index_json'], compact_property($this, 'users'));
                break;
            default:
                $render = Redirect::route('home')->with('message', "Error: Unknown request");
                break;
        }

        return $render;
    }
}
*/