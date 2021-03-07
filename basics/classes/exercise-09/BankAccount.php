<?php

namespace BankAccount;

use NumberFormatter;

class BankAccount
{
    private const CURRENCY = 'USD';

    private string $name;
    private int $balance;
    private NumberFormatter $fmt;

    public function __construct(string $name, int $balance)
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
    }

    public function showUsernameAndBalance(): string
    {
        return $this->name . ', ' . $this->fmt->formatCurrency($this->balance / 100, self::CURRENCY);
    }
}
