<?php

namespace Efficiently\JqueryLaravel;

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
     *               If $options is a boolean, if it's `false`, no layout is applied on the view.
     *               If $options is an array, default values are: ['status' => 200, 'headers' => []]
     * @return \Illuminate\Http\Response
     */
    public function render($view, $data = [], $options = null)
    {
        list($view, $options) = $this->makeView($view, $data, $options);

        return $this->makeResponse($view, $options);
    }

    /**
     * @param  \Illuminate\View\View|string|array $view    [description]
     * @param  array  $data
     * @param  mixed $options
     * @return array [\Illuminate\View\View $view, array $options]
     */
    protected function makeView($view, $data = [], $options = null)
    {
        $layout = null;
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

        $format = null; // if `null`, it uses the 'html' format by default
        if (is_array($view) && count($view) === 1) {
            $format = array_keys($view)[0];
            $view = array_values($view)[0];
            if (is_string($view)) {
                if (! ends_with($view, '_'.$format) && view()->exists($view.'_'.$format)) {
                    $view = $view.'_'.$format;
                } else {
                    // Inline view
                    $view = Blade::compileString($view);
                }
            }
            if ($format === 'html') {
                $format = null; // if `null`, it uses the 'html' format by default
            }
            // If the format isn't 'html' and no custom layout is provided
            // The default layout should not be use
            if ($format && is_null($layout)) {
                $layout = false;
            }
        }

        if (is_string($view) && view()->exists($view)) {
            // Transform the $view string path to a View object
            $view = view($view, $data);
        }

        $this->setupLayout($layout);
        if ($this->layout && $this->layout->getName() !== $view->getName()) {
            $this->layout->with('content', $view);
            $view = $this->layout;
        }
        $options['format'] = $format;

        return [$view, $options];
    }

    /**
     * @param  \Illuminate\View\View $view
     * @param  array $options
     * @return \Illuminate\Http\Response
     */
    protected function makeResponse($view, $options = [])
    {
        $format = array_pull($options, 'format');
        $defaultOptions = ['status' => 200, 'headers' => []];
        $options = array_merge($defaultOptions, $options);

        if (response()->hasMacro('makeWithTurbolinks')) {
            $response = response()->makeWithTurbolinks($view, $options);
        } else {
            $response = response($view, $options['status'], $options['headers']);
        }
        if ($format) {
            $response->header('Content-Type', Request::getMimeType($format));
        }

        return $response;
    }

    /**
     * @param  string $path URL
     * @param  array $options Default to: ['status' => 302, 'headers' => [], 'secure' => null]
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
     * @param  string|bool|\Illuminate\View\View $layout Custom layout
     * @return void
     */
    protected function setupLayout($layout = null)
    {
        $this->layout = !is_null($layout) ? $layout : $this->layout;
        if ($this->layout && is_string($this->layout) && view()->exists($this->layout)) {
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
