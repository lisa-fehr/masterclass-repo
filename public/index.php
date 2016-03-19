<?php
use Masterclass\Configuration\DiConfig;
use Masterclass\Configuration\RouterConfig;

session_start();

$path = realpath(__DIR__ . '/..');
require_once($path . '/vendor/autoload.php');
$config = function() use ($path) {
    return require($path . '/src/Configuration/config.php');
};

$diContainerBuilder = new Aura\Di\ContainerBuilder();
$di = $diContainerBuilder->newInstance(['config' => $config], [DiConfig::class, RouterConfig::class]);
$framework = $di->newInstance('Masterclass\MainController\MasterController');

echo $framework->execute();
