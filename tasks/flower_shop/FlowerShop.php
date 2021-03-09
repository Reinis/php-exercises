<?php

namespace FlowerShop;

use InvalidArgumentException;

class FlowerShop
{
    /**
     * @var WarehouseInterface[]
     */
    private array $warehouses;
    private Flowers $flowers;
    private array $prices;

    public function __construct(WarehouseInterface ...$warehouses)
    {
        foreach ($warehouses as $warehouse) {
            $this->warehouses[$warehouse->getName()] = $warehouse;
        }

        $this->flowers = new Flowers();
    }

    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }

    public function getPrice(string $name): int
    {
        if (!isset($this->prices[$name])) {
            throw new InvalidArgumentException("Flower not available in the shop!");
        }

        return $this->prices[$name];
    }

    public function stockFlowers(Flowers $flowers): string
    {
        $messages = '';

        foreach ($flowers as $targetFlower) {
            $currentFlower = new Flower($targetFlower->getName(), 0);
            $name = $targetFlower->getName();

            foreach ($this->warehouses as $warehouse) {
                try {
                    $warehouseFlower = $warehouse->getFlowerByName($name);
                    $available = $warehouseFlower->getAmount();

                    if ($available > $targetFlower->getAmount()) {
                        $warehouseFlower->subtractAmount($targetFlower->getAmount());
                        $currentFlower->addAmount($targetFlower->getAmount());
                        $targetFlower->setAmount(0);
                        break;
                    }

                    $warehouseFlower->setAmount(0);
                    $currentFlower->addAmount($available);
                    $targetFlower->subtractAmount($available);
                } catch (InvalidArgumentException $exception) {
                    $messages .= $exception->getMessage() . PHP_EOL;
                    continue;
                }
            }

            $this->flowers->addFlowers($currentFlower);
        }

        return $messages;
    }

    public function isAvailable(string $name): bool
    {
        try {
            $flower = $this->flowers->getFlowerByName($name);

            return $flower->getAmount() > 0;
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }

    public function numAvailable(string $name): int
    {
        try {
            $flower = $this->flowers->getFlowerByName($name);

            return $flower->getAmount();
        } catch (InvalidArgumentException $exception) {
            return 0;
        }
    }

    public function list(): string
    {
        $items = '';

        foreach ($this->flowers as $flower) {
            $price = $this->prices[$flower->getName()];
            $items .= sprintf("%-10s %10d %5d\n", $flower->getName(), $flower->getAmount(), $price);
        }

        return $items;
    }
}
