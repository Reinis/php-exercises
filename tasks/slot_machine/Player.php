<?php

namespace SlotMachine;

class Player
{
    private int $amount = 0;
    private int $bet = 0;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function reward(int $amount): void
    {
        $this->amount += $amount;
    }

    public function getBet(): int
    {
        return $this->bet;
    }

    public function setBet(int $bet): void
    {
        $this->bet = $bet;
        $this->amount -= $bet;
    }
}
