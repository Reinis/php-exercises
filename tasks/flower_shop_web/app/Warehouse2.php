<?php

namespace FlowerShopWeb;

use FlowerShopWeb\Services\CSVService;

class Warehouse2 extends Warehouse
{
    public function __construct(string $name, string $fileName)
    {
        $dataService = new CSVService($fileName);

        parent::__construct($name, $dataService);
    }
}
