<?php

namespace Masterclass\Route;

/**
 * Class AbstractRoute
 * @package Masterclass\Route
 */
abstract class AbstractRoute implements RouteInterface
{
    /**
     * @var string
     */
    protected $routePath;

    /**
     * @var string
     */
    protected $routeClass;

    /**
     * @var string
     */
    protected $routeMethod;

    /**
     * AbstractRoute constructor.
     * @param string $routePath
     * @param string $routeClass
     * @param string $routeMethod
     */
    public function __construct($routePath, $routeClass, $routeMethod)
    {
        $this->routeClass = $routeClass;
        $this->routePath = $routePath;
        $this->routeMethod = $routeMethod;
    }

    /**
     * @return string
     */
    public function getRoutePath()
    {
        return $this->routePath;
    }

    /**
     * @return string
     */
    public function getRouteClass()
    {
        return $this->routeClass;
    }

    /**
     * @return string
     */
    public function getRouteMethod()
    {
        return $this->routeMethod;
    }

    /**
     * @param string $requestPath
     * @param string $requestType
     * @return bool
     */
    abstract public function matchRoute($requestPath, $requestType);
}
