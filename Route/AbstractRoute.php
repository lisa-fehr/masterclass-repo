<?php

namespace Masterclass\Route;

abstract class AbstractRoute implements RouteInterface
{
    protected $routePath;
    protected $routeClass;
    protected $routeMethod;

    public function __construct($routePath, $routeClass, $routeMethod)
    {
        $this->routeClass = $routeClass;
        $this->routePath = $routePath;
    }

    public function getRoutePath()
    {
        return $this->routePath;
    }

    public function getRouteClass()
    {
        return $this->routeClass;
    }

    public function getRouteMethod()
    {
        return $this->routeMethod;
    }

    abstract public function matchRoute($requestPath, $requestType);
}
