<?php

namespace SavingsAccount;

use NumberFormatter;

class Program
{
    private const CURRENCY = 'USD';

    public function main(): void
    {
        $balance = $this->getStartingBalance();
        $annualInterestRate = $this->getAnnualInterestRate();
        $numberOfMonths = $this->getNumberOfMonths();

        $account = new SavingsAccount($balance);
        $account->setMonthlyInterestRate($annualInterestRate);

        for ($i = 1; $i <= $numberOfMonths; $i++) {
            $deposit = $this->getMonthlyDeposit($i);
            $withdrawal = $this->getMonthlyWithdrawal($i);

            $account->deposit($deposit);
            $account->withdraw($withdrawal);
            $account->addMonthlyInterest();
        }

        $fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        echo "Total deposited: " . $fmt->formatCurrency($account->getTotalDeposited(), self::CURRENCY) . PHP_EOL;
        echo "Total withdrawn: " . $fmt->formatCurrency($account->getTotalWithdrawn(), self::CURRENCY) . PHP_EOL;
        echo "Interest earned: " . $fmt->formatCurrency($account->getTotalInterestEarned(), self::CURRENCY) . PHP_EOL;
        echo "Balance: " . $fmt->formatCurrency($account->getBalance(), self::CURRENCY) . PHP_EOL;
    }

    private function getStartingBalance(): int
    {
        do {
            $balance = filter_var(readline('-> Starting balance: '), FILTER_VALIDATE_FLOAT);
        } while ($balance === false || $balance <= 0.0);

        return $balance * 100;
    }

    private function getAnnualInterestRate(): float
    {
        do {
            $annualInterestRate = filter_var(readline('-> Annual interest rate: '), FILTER_VALIDATE_FLOAT);
        } while ($annualInterestRate === false);

        return $annualInterestRate;
    }

    private function getNumberOfMonths(): int
    {
        do {
            $numberOfMonths = filter_var(readline('-> Number of months: '), FILTER_VALIDATE_INT);
        } while ($numberOfMonths === false);

        return $numberOfMonths;
    }

    private function getMonthlyDeposit(int $i): int
    {
        do {
            $input = readline("Enter amount deposited for month: {$i}: ");
            $deposited = filter_var($input, FILTER_VALIDATE_FLOAT);
        } while ($deposited === false || $deposited < 0.0);

        return $input * 100;
    }

    private function getMonthlyWithdrawal(int $i): int
    {
        do {
            $input = readline("Enter amount withdrawn for {$i}: ");
            $withdrawn = filter_var($input, FILTER_VALIDATE_FLOAT);
        } while ($withdrawn === false);

        return $withdrawn * 100;
    }
}
