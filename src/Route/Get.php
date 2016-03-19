<?php

namespace Masterclass\Route;

/**
 * Class Get
 * @package Masterclass\Route
 */
class Get extends AbstractRoute
{
    /**
     * @param string $requestPath
     * @param string $requestType
     * @return bool
     */
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'GET') {
            return false;
        }
        if ($this->routePath != rtrim($requestPath, '/')) {
            return false;
        }

        return true;
    }
}
