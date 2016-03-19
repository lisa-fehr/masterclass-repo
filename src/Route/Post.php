<?php

namespace Masterclass\Route;

/**
 * Class Post
 * @package Masterclass\Route
 */
class Post extends AbstractRoute
{
    /**
     * @param string $requestPath
     * @param string $requestType
     * @return bool
     */
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'POST') {
            return false;
        }
        if ($this->routePath != rtrim($requestPath, '/')) {
            return false;
        }

        return true;
    }
}
