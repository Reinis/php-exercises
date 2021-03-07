<?php

declare(strict_types=1);

ini_set('zend.assertions', '1');

use Dog\DogTest;

require_once 'Gender.php';
require_once 'Dog.php';
require_once 'DogTest.php';


$dogTest = new DogTest();
$dogTest->main();
