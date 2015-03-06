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
            $view = view($view, $data);
        }

        // short circuit
        if ($format) {
            $response = response($view);
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
        if (! is_null($this->layout)) {
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
