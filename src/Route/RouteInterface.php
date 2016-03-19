<?php

namespace Masterclass\Route;

/**
 * Interface RouteInterface
 * @package Masterclass\Route
 */
interface RouteInterface
{
    /**
     * @param string $requestPath
     * @param string $requestType
     * @return bool
     */
    public function matchRoute($requestPath, $requestType);

    /**
     * @return string
     */
    public function getRoutePath();

    /**
     * @return string
     */
    public function getRouteClass();
}
