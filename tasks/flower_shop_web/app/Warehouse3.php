<?php

namespace FlowerShopWeb;

use FlowerShopWeb\Services\JSONService;

class Warehouse3 extends Warehouse
{
    public function __construct(string $name, string $fileName)
    {
        $dataService = new JSONService($fileName);

        parent::__construct($name, $dataService);
    }
}
