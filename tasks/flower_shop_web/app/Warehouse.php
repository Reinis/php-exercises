<?php

namespace FlowerShopWeb;

use FlowerShopWeb\Services\DataServiceInterface;
use InvalidArgumentException;

class Warehouse implements WarehouseInterface
{
    private DataServiceInterface $dataService;
    private string $name;

    public function __construct(string $name, DataServiceInterface $dataService)
    {
        $this->name = $name;
        $this->dataService = $dataService;
    }

    public function getFlowerByName(string $name): Flower
    {
        try {
            $product = $this->dataService->getProductByName($name);
        } catch (InvalidArgumentException $e) {
            $message = $e->getMessage() . " in " . $this->getName();
            throw new InvalidArgumentException($message);
        }

        return new Flower($product->getName(), $product->getAmount());
    }

    public function getName(): string
    {
        return $this->name;
    }
}
