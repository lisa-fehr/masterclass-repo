<?php

session_start();

$path = realpath(__DIR__ . '/..');
$config = function() use ($path) {
    return require($path . '/Configuration/config.php');
};
require_once($path . '/vendor/autoload.php');

$diContainerBuilder = new Aura\Di\ContainerBuilder();
$di = $diContainerBuilder->newInstance(['config' => $config], ['Masterclass\Configuration\DiConfig', 'Masterclass\Configuration\RouterConfig']);
$framework = $di->newInstance('Masterclass\MainController\MasterController');

echo $framework->execute();
