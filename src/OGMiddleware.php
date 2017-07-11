<?php

namespace Evabioz\OGMiddleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class OGMiddleware
{
    /**
     * The application instance
     *
     * @var Application
     */
    private $app;

    /**
     * List of crawler user agents that will be
     *
     * @var array
     */
    private $crawlerUserAgents;

    /**
     * Routes and endpoints
     *
     * @var array
     */
    private $routeEndpointList;

    /**
     * Creates a new instance
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $config = $app['config']->get('og-middleware');

        $this->crawlerUserAgents = $config['crawler_user_agents'];
        $this->routeEndpointList = $config['route_endpoint_list'];
    }

    /**
     * Handles a request if it should, otherwise call the next middleware.
     *
     * @param $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        if ($this->shouldShowOpenGraph($request)) {
            $endpoint = $this->getEndpoint();

            if (!$endpoint) {
                return $next($request);
            }

            $response = $this->app->make(ResponseFactory::class);
            return $response->make($this->outputHtml($endpoint));
        }

        return $next($request);
    }

    /**
     * Returns whether the request must be crawler.
     *
     * @param $request
     * @return bool
     */
    private function shouldShowOpenGraph($request)
    {
        $userAgent = strtolower($request->server->get('HTTP_USER_AGENT'));
        $bufferAgent = $request->server->get('X-BUFFERBOT');

        $isCrawlerRequesting = false;

        if (!$userAgent) return false;
        if (!$request->isMethod('GET')) return false;

        // if _escaped_fragment_ is in the query string
        if ($request->query->has('_escaped_fragment_')) {
            $isCrawlerRequesting = true;
        }

        // if a crawler is detected
        foreach ($this->crawlerUserAgents as $crawlerUserAgent) {
            if (str_contains($userAgent, strtolower($crawlerUserAgent))) {
                $isCrawlerRequesting = true;
            }
        }

        if ($bufferAgent) {
            $isCrawlerRequesting = true;
        }

        return $isCrawlerRequesting;
    }

    /**
     * Get the instance of endpoint as Open Graph object.
     *
     * @return null|OpenGraphEndpoint
     */
    protected function getEndpoint()
    {
        $result = null;

        // only check route if it is matched.
        foreach ($this->routeEndpointList as $route => $endpoint) {
            if ($this->isPath($route) || $this->isRoute($route)) {
                $result = $this->app->make($endpoint);
                break;
            }
        }

        return $result;
    }


    /**
     * Determine if the current path is one of the provided paths.
     *
     * @param  mixed   $routes
     * @return boolean
     */
    private function isPath($routes)
    {
        $request = $this->app['request'];
        $routes = is_array($routes) ? $routes : func_get_args();
        return call_user_func_array([$request, 'is'], $routes);
    }

    /**
     * Determin if the current route is one of the provided routes.
     *
     * @param  mixed  $routes
     * @return boolean
     */
    private function isRoute($routes)
    {
        $router = $this->app['router'];
        $routes = is_array($routes) ? $routes : func_get_args();
        return call_user_func_array([$router, 'is'], $routes);
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function outputHtml(OpenGraphEndpoint $og)
    {
        $viewer = $this->app['view']->make('og-middleware::open_graph');
        return $viewer->with(compact('og'))->render();
    }
}
