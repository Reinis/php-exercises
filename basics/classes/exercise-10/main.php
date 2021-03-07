<?php

declare(strict_types=1);

use VideoStore\Application;

require_once 'Video.php';
require_once 'VideoStore.php';
require_once 'Application.php';


$app = new Application();
$app->run();
