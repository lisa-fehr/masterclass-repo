<?php

namespace Masterclass\Route;

/**
 * Class Router
 * @package Masterclass\Route
 */
class Router
{
    /**
     * @var array
     */
    protected $serverVars;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * Router constructor.
     * @param array $serverVars
     * @param array $routes
     */
    public function __construct(array $serverVars, array $routes = [])
    {
        $this->serverVars = $serverVars;
        foreach ($routes as $route) {
            $this->addRoute($route);
        }
    }

    /**
     * @param RouteInterface $route
     */
    public function addRoute(RouteInterface $route)
    {
        $this->routes[] = $route;
    }

    /**
     * @return string|bool
     */
    public function findRoute()
    {
        $path = parse_url($this->serverVars['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route->matchRoute($path, $this->serverVars['REQUEST_METHOD'])) {
                return $route;
            }
        }

        return false;
    }
}
