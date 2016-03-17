<?php

$reflector = new Aura\Di\Resolver\Reflector();
$resolver = new Aura\Di\Resolver\Resolver($reflector);
$injection_factory = new Aura\Di\Injection\InjectionFactory($resolver);

$di = new Aura\Di\Container($injection_factory);

$db = $config['database'];
$dsn = 'mysql:host=' . $db['host'] . ';dbname=' . $db['name'];

$di->params['PDO'] = [
    'dsn' => $dsn,
    'username' => $db['user'],
    'passwd' => $db['pass'],
    'options' => [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]
];

$di->params['Masterclass\Model\BaseModel'] = [
    'pdo' => $di->lazyNew('PDO')
];

$di->params['Masterclass\MainController\MasterController'] = [
    'container' => $di,
    'config' => $config,
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
