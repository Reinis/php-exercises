<?php

namespace FlowerShopWeb\Entities;

class Product
{
    private int $id;
    private string $name;
    private int $price;
    private int $amount;

    public function getId(): int
    {
        return $this->id;
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
}
