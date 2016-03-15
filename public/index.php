<?php

use Masterclass\MainController\MasterController;

session_start();

$config = require_once('../config.php');
require_once '../vendor/autoload.php';

$framework = new MasterController($config);
echo $framework->execute();