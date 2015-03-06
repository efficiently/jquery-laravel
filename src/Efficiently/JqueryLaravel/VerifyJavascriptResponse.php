<?php namespace Efficiently\JqueryLaravel;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Log;

// Verify that we aren't serving an unauthorized cross-origin JavaScript response.

class VerifyJavascriptResponse implements Middleware
{

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     *
     * @throws \Efficiently\JqueryLaravel\CrossOriginRequestException;
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if ($this->isReading($request) &&
            $this->nonXhrJavascriptResponse($request, $response)
        ) {
            $crossOriginJavascriptWarning = "Security warning: an embedded " .
                "<script> tag on another site requested protected JavaScript. " .
                "If you know what you're doing, go ahead and disable CSRF " .
                "protection on this action to permit cross-origin JavaScript embedding.";

            throw new CrossOriginRequestException($crossOriginJavascriptWarning);
        }

        return $response;
    }
    /**
     * Determine if the the response isn't a XHR(AJAX) Javascript one
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $response
     * @return bool
     */
    protected function nonXhrJavascriptResponse($request, $response)
    {
        return ($request->getFormat($response->headers->get('Content-Type')) === 'js' &&
            ! $request->ajax()
        );
    }

    /**
     * Determine if the HTTP request uses a ‘read’ verb.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isReading($request)
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }
}
