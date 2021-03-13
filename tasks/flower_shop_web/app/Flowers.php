<?php

namespace FlowerShopWeb;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;

class Flowers implements IteratorAggregate
{
    /**
     * @var Flower[]
     */
    private array $flowers = [];

    public function __construct(Flower ...$flowers)
    {
        if ($flowers !== null) {
            foreach ($flowers as $flower) {
                $this->flowers[$flower->getName()] = $flower;
            }
        }
    }

    public function getFlowerByName(string $name): Flower
    {
        if (!isset($this->flowers[$name])) {
            throw new InvalidArgumentException("Flower not found: {$name}");
        }

        return $this->flowers[$name];
    }

    public function addFlower(Flower $flower): void
    {
        $name = $flower->getName();

        if (!isset($this->flowers[$name])) {
            $this->flowers[$name] = $flower;
        } else {
            $this->flowers[$name]->addAmount($flower->getAmount());
        }
    }

    /**
     * @return ArrayIterator|Flower[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->flowers);
    }
}
