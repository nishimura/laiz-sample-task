<?php

chdir(dirname(__DIR__));


error_reporting(-1);

require 'vendor/autoload.php';

Laiz\Core\Controller::init()->run();
