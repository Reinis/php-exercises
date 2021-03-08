<?php

namespace Accounts;

use InvalidArgumentException;

class Program
{
    public function main(): void
    {
        $account = new Account("Mine", 100.0);
        $account->deposit(20.0);
        echo $account;
    }

    public function main2(): void
    {
        $matt = new Account("Matt's account", 1000);
        $mine = new Account("My account", 0);

        $matt->withdrawal(100.0);
        $mine->deposit(100.0);

        echo $matt;
        echo $mine;
    }

    public function main3(): void
    {
        $A = new Account("A", 100.0);
        $B = new Account("B", 0.0);
        $C = new Account("C", 0.0);

        $this->transfer($A, $B, 5000);
        $this->transfer($B, $C, 2500);

        echo $A;
        echo $B;
        echo $C;
    }

    public function transfer(Account $from, Account $to, int $howMuch): void
    {
        if ($howMuch < 0) {
            throw new InvalidArgumentException("Invalid amount: {$howMuch}");
        }

        $from->withdrawal($howMuch / 100);
        $to->deposit($howMuch / 100);
    }
}
