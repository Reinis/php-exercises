<?php

namespace Accounts;

use InvalidArgumentException;
use NumberFormatter;

class Account
{
    private const CURRENCY = 'USD';
    private const LOCALE = 'en_US';

    private string $title;
    private int $balance;
    private NumberFormatter $fmt;

    public function __construct(string $title, float $balance)
    {
        $this->title = $title;
        $this->balance = round($balance * 100);
        $this->fmt = new NumberFormatter(self::LOCALE, NumberFormatter::CURRENCY);
    }

    public function __toString(): string
    {
        return $this->title
            . ', balance: '
            . $this->fmt->formatCurrency($this->balance / 100, self::CURRENCY)
            . PHP_EOL;
    }

    public function balance(): string
    {
        return $this->fmt->formatCurrency($this->balance / 100, self::CURRENCY);
    }

    public function withdrawal(float $amount): void
    {
        if ($amount < 0) {
            throw new InvalidArgumentException("Invalid amount: {$amount}");
        }

        $this->balance -= $amount * 100;
    }

    public function deposit(float $amount): void
    {
        if ($amount < 0) {
            throw new InvalidArgumentException("Invalid amount: {$amount}");
        }

        $this->balance += $amount * 100;
    }
}
