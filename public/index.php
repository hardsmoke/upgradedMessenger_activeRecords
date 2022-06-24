<?php

use Messenger\Application;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$application = new Application();
echo $application->run();
