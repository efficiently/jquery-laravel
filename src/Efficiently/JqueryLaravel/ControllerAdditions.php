<?php namespace Efficiently\JqueryLaravel;

use Blade;
use Request;
use Response;

trait ControllerAdditions
{
    /**
     * @param  \Illuminate\View\View|string|array $view View object or view path
     * @param  array $data Data that should be made available to the view. Only used when $view is a string path
     * @param  mixed $options If $options is a string, it's used as the master layout path of the view.
     *               E.G. $this->render('messages.index', 'app'); where the layout 'app' is the 'resources/views/app.blade.php' file.
     *               If $options is null, the master layout is set with the value of the Controller::$layout property.
     *               If $options is a boolean, if`it's `false`, no layout is applied on the view.
     *               If $options is an array, default values are: ['status' => 200, 'headers' => []]
     *
     * @return \Illuminate\Http\Response
     */
    public function render($view, $data = [], $options = null)
    {
        $layout = null;
        $defaultOptions = ['status' => 200, 'headers' => []];
        if (is_string($options)) {
            // To support legacy behaviour
            $layout = $options;
            $options = [];
        } elseif (is_array($options)) {
            if (array_key_exists('layout', $options)) {
                $layout = $options['layout'];
                unset($options['layout']);
            }
        } else {
            if ($options === false) {
                // To support legacy behaviour
                $layout = false;
            }
            $options = [];
        }
        $options = array_merge($defaultOptions, $options);

        $format = null; // if `null`, it uses the 'html' format by default
        if (is_array($view) && count($view) === 1) {
            $format = array_keys($view)[0];
            $view = array_values($view)[0];
            if (is_string($view)) {
                if (! ends_with($view, '_'.$format) && view()->exists($view.'_'.$format)) {
                    $view = $view.'_'.$format;
                } else {
                    // inline view
                    $view = Blade::compileString($view);
                }
            }
        }

        if (is_string($view) && view()->exists($view)) {
            // Transform the $view string path to a View object
            $view = view($view, $data);
        }

        // short circuit
        if ($format) {
            $response = response($view, $options['status'], $options['headers']);
            $response->header('Content-Type', Request::getMimeType($format));

            return $response;
        }

        if (! is_null($layout)) {
            $this->layout = $layout;
            $this->setupLayout();
        }

        $render = $view;
        if ($this->layout) {
            $this->layout->content = $view;
            $render = $this->layout;
        }

        if (response()->hasMacro('makeWithTurbolinks')) {
            return response()->makeWithTurbolinks($render, $options);
        }

        return response()->make($render, $options['status'], $options['headers']);
    }

    /**
     * @param  string $path URL
     * @param  array $options Default to: ['status' => 302, 'headers' => [], 'secure' => null]
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectTo($path, $options = [])
    {
        $defaultOptions = ['status' => 302, 'headers' => [], 'secure' => null];
        $options = array_merge($defaultOptions, $options);
        if (response()->hasMacro('redirectToWithTurbolinks')) {
            return response()->redirectToWithTurbolinks($path, $options);
        }

        return response()->redirectTo($path, $options['status'], $options['headers'], $options['secure']);
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ($this->layout) {
            $this->layout = view($this->layout);
        }
    }

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $this->setupLayout();

        return parent::callAction($method, $parameters);
    }
}
