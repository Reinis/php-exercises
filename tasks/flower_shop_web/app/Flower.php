<?php

namespace FlowerShopWeb;

class Flower
{
    private string $name;
    private int $amount;

    public function __construct(string $name, int $amount)
    {
        $this->name = $name;
        $this->amount = $amount;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function addAmount(int $amount): void
    {
        $this->amount += $amount;
    }

    public function subtractAmount(int $amount): void
    {
        $this->amount -= $amount;
    }
}
