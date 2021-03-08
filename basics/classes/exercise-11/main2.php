<?php

declare(strict_types=1);

use Accounts\Program;

require_once 'Account.php';
require_once 'Program.php';


$program = new Program();
echo "\n=== Your first account\n";
$program->main();

echo "\n=== Your first money transfer\n";
$program->main2();

echo "\n=== Money transfers\n";
$program->main3();
