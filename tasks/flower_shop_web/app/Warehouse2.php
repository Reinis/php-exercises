<?php

namespace FlowerShopWeb;

use FlowerShopWeb\Services\CSVService;
use InvalidArgumentException;

class Warehouse2 extends Warehouse
{
    public function __construct(string $name, string $fileName)
    {
        $this->dataService = new CSVService($fileName);

        parent::__construct($name, new Flowers());
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
}
