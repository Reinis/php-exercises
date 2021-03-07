<?php

declare(strict_types=1);

use BankAccount\BankAccount;

require_once 'BankAccount.php';


$account = new BankAccount('Benson', -1750);
echo $account->showUsernameAndBalance() . PHP_EOL;
