<?php

namespace Masterclass\MainController;

use Aura\Di\Container;
use Masterclass\Route\Router;

class MasterController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Container
     */
    protected $container;

    /**
     * MasterController constructor.
     * @param Container $container
     * @param array     $config
     * @param Router    $router
     */
    public function __construct(Container $container, array $config = [], Router $router)
    {
        $this->container = $container;
        $this->config = $config;
        $this->router = $router;
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        $call = $this->_determineControllers();
        $class = $call->getRouteClass();
        $method = $call->getRouteMethod();

        $o = $this->container->newInstance($class);

        return $o->$method();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function _determineControllers()
    {
        $router = $this->router;
        $route = $router->findRoute();

        if (empty($route)) {
            throw new \Exception('No route match found!');
        }

        return $route;
    }

}
