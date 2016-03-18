<?php

namespace Masterclass\Configuration;

use Aura\Di\ContainerConfig;
use Aura\Di\Container;
//use PDO;

class DiConfig extends ContainerConfig
{
    public function define(Container $di)
    {
        $config = $di->get('config');
        $db = $config['database'];
        $dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

        $di->params['Masterclass\Database\AbstractDb'] = [
            'dsn' => $dsn,
            'user' => $db['user'],
            'pass' => $db['pass'],
            //'options' => [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]
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
