<?php

namespace SlotMachine;

class Player
{
    private int $amount = 0;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function deduct(int $amount): void
    {
        $this->amount -= $amount;
    }

    public function reward(int $amount): void
    {
        $this->amount += $amount;
    }
}
