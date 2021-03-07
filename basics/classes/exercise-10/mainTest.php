<?php

declare(strict_types=1);

use VideoStore\VideoStoreTest;

require_once 'Video.php';
require_once 'VideoStore.php';
require_once 'VideoStoreTest.php';


$app = new VideoStoreTest();
$app->main();
