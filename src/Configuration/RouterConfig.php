<?php

namespace Masterclass\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;
use Masterclass\Route\Get as RouteGet;
use Masterclass\Route\Post as RoutePost;

/**
 * Class RouterConfig
 * @package Masterclass\Configuration
 */
class RouterConfig extends Config
{
    /**
     * @param Container $di
     * @throws \Aura\Di\Exception\ServiceNotFound
     */
    public function define(Container $di)
    {
        $config = $di->get('config');
        $routes = $config['routes'];
        $routeObj = [];
        foreach ($routes as $path => $route) {
            if ($route['request'] == 'POST') {
                $routeObj[] = new RoutePost($path, $route['class'], $route['method']);
            } else {
                $routeObj[] = new RouteGet($path, $route['class'], $route['method']);
            }
        }
        $di->params['Masterclass\Route\Router'] = [
            'serverVars' => $_SERVER,
            'routes' => $routeObj,
        ];
    }
}
