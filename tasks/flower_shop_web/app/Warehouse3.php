<?php

namespace FlowerShopWeb;

use Exception;
use FlowerShopWeb\Services\JSONService;
use InvalidArgumentException;

class Warehouse3 extends Warehouse
{
    public function __construct(string $name, string $fileName)
    {
        $this->dataService = new JSONService($fileName);

        parent::__construct($name, new Flowers());
    }

    /**
     * @param string $name
     * @return Flower
     * @throws Exception
     */
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
