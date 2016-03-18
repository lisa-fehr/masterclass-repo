<?php

namespace Masterclass\Route;

class Post extends AbstractRoute
{
    public function matchRoute($requestPath, $requestType)
    {
        if ($requestType != 'POST') {
            return false;
        }
        if ($this->routePath != $requestPath) {
            return false;
        }

        return true;
    }
}
