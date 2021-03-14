<?php

namespace FlowerShopWeb;

use Generator;
use IteratorAggregate;

class Invoice implements IteratorAggregate
{
    private string $name;
    private int $price;
    private int $amount;
    private int $total;

    public function __construct(string $name, int $price, int $amount, int $total)
    {
        $this->name = $name;
        $this->price = $price;
        $this->amount = $amount;
        $this->total = $total;
    }

    public function getIterator(): Generator
    {
        foreach (get_object_vars($this) as $key => $value) {
            yield $key => $value;
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
