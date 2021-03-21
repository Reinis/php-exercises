<?php

namespace FlowerShopWeb;

use FlowerShopWeb\Services\PDOService;
use InvalidArgumentException;

class Warehouse1 extends Warehouse
{
    public function __construct(string $name, string $connectionString, string $user, string $password)
    {
        $this->dataService = new PDOService($connectionString, $user, $password);

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
