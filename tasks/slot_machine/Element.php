<?php

namespace SlotMachine;

class Element
{
    private string $symbol;
    private int $value;
    private int $weight;
    private bool $bonus;

    public function __construct(string $symbol, int $value, int $weight, bool $bonus = false)
    {
        $this->symbol = $symbol;
        $this->value = $value;
        $this->weight = $weight;
        $this->bonus = $bonus;
    }

    public function __toString(): string
    {
        return $this->getSymbol();
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function repeat(): array
    {
        return array_fill(0, $this->getWeight(), $this);
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isBonus(): bool
    {
        return $this->bonus;
    }
}
