<?php

namespace FlowerShopWeb;

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

    public function getIterator(): iterable
    {
        yield 'name' => $this->getName();
        yield 'price' => $this->getPrice();
        yield 'amount' => $this->getAmount();
        yield 'total' => $this->getTotal();
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
