<?php

namespace SavingsAccount;

use InvalidArgumentException;

class SavingsAccount
{
    private int $balance;
    private float $monthlyInterestRate = 0.0;
    /**
     * @var int[]
     */
    private array $deposits = [];
    /**
     * @var int[]
     */
    private array $withdrawals = [];
    /**
     * @var int[]
     */
    private array $interestsEarned = [];

    public function __construct(int $balance)
    {
        $this->balance = $balance;
    }

    public function deposit(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Invalid deposit amount: {$amount}");
        }

        $this->balance += $amount;
        $this->deposits[] = $amount;
    }

    public function withdraw(int $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Invalid withdrawal amount: {$amount}");
        }

        $this->balance -= $amount;
        $this->withdrawals[] = $amount;
    }

    public function addMonthlyInterest(): void
    {
        $interest = round($this->balance * $this->monthlyInterestRate);

        $this->balance += $interest;
        $this->interestsEarned[] = $interest;
    }

    public function setMonthlyInterestRate(float $annualInterestRate): void
    {
        $this->monthlyInterestRate = $annualInterestRate / 12;
    }

    public function getBalance(): float
    {
        return $this->balance / 100;
    }

    public function getTotalDeposited(): float
    {
        return array_sum($this->deposits) / 100;
    }

    public function getTotalWithdrawn(): float
    {
        return array_sum($this->withdrawals) / 100;
    }

    public function getTotalInterestEarned(): float
    {
        return array_sum($this->interestsEarned) / 100;
    }
}
