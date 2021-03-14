<?php

namespace FlowerShopWeb;

use JsonCollectionParser\Parser;

class Warehouse3 extends Warehouse
{
    public function __construct(string $name, string $jsonFileName)
    {
        $flowers = $this->readFlowersFromJsonFile($jsonFileName);

        parent::__construct($name, $flowers);
    }

    private function readFlowersFromJsonFile(string $jsonFileName): Flowers
    {
        $filename = 'storage/' . $jsonFileName;
        $flowers = new Flowers();
        $parser = new Parser();

        $parser->parse(
            $filename,
            fn(array $item) => $flowers->addFlower(new Flower($item['name'], $item['amount']))
        );

        return $flowers;
    }
}
