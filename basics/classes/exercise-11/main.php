<?php

declare(strict_types=1);

use Accounts\Account;

require_once 'Account.php';


$bartos_account = new Account("Barto's account", 100.00);
$bartos_swiss_account = new Account("Barto's account in Switzerland", 1000000.00);

echo "Initial state\n";
echo $bartos_account;
echo $bartos_swiss_account;

$bartos_account->withdrawal(20);
echo "Barto's account balance is now: " . $bartos_account->balance() . PHP_EOL;
$bartos_swiss_account->deposit(200);
echo "Barto's Swiss account balance is now: " . $bartos_swiss_account->balance() . PHP_EOL;

echo "Final state\n";
echo $bartos_account;
echo $bartos_swiss_account;
