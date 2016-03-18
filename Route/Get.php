<?php

namespace Masterclass\Route;

class Get extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'GET') {
            return false;
        }
        if ($this->routePath != $requestPath) {
            return false;
        }

        return true;
    }
}
