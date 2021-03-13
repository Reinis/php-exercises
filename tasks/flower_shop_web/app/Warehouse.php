<?php

namespace FlowerShopWeb;

use InvalidArgumentException;

class Warehouse implements WarehouseInterface
{
    private string $name;
    private Flowers $flowers;

    public function __construct(string $name, Flowers $flowers)
    {
        $this->name = $name;
        $this->flowers = $flowers;
    }

    public function getFlowerByName(string $name): Flower
    {
        try {
            return $this->flowers->getFlowerByName($name);
        } catch (InvalidArgumentException $exception) {
            $message = $exception->getMessage() . " in " . $this->getName();
            throw new InvalidArgumentException($message);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }
}
