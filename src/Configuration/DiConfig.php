<?php

namespace Masterclass\Configuration;

use Aura\Di\Config;
use Aura\Di\Container;

/**
 * Class DiConfig
 * @package Masterclass\Configuration
 */
class DiConfig extends Config
{
    /**
     * @param Container $di
     * @throws \Aura\Di\Exception\ServiceNotFound
     */
    public function define(Container $di)
    {
        $config = $di->get('config');
        $db = $config['database'];
        $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

        $di->params['Masterclass\Database\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $db['user'],
            'pass' => $db['pass'],
        ];
        $di->params['Masterclass\Model\BaseModel'] = [
            'db' => $di->lazyNew('Masterclass\Database\Mysql')
        ];
        $di->params['Masterclass\MainController\MasterController'] = [
            'container' => $di,
            'config' => $config,
            'router' => $di->lazyNew('Masterclass\Route\Router'),
        ];
        $di->params['Masterclass\Controller\Comment'] = [
            'comment' => $di->lazyNew('Masterclass\Model\Comment'),
        ];
        $di->params['Masterclass\Controller\Story'] = [
            'story' => $di->lazyNew('Masterclass\Model\Story'),
            'comment' => $di->lazyNew('Masterclass\Model\Comment'),
        ];
        $di->params['Masterclass\Controller\Index'] = [
            'story' => $di->lazyNew('Masterclass\Model\Story'),
            'comment' => $di->lazyNew('Masterclass\Model\Comment'),
        ];
        $di->params['Masterclass\Controller\User'] = [
            'user' => $di->lazyNew('Masterclass\Model\User'),
        ];
    }
}
