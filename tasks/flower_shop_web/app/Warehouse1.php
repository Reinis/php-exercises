<?php

namespace FlowerShopWeb;

use FlowerShopWeb\Services\PDOService;

class Warehouse1 extends Warehouse
{
    public function __construct(string $name, string $connectionString, string $user, string $password)
    {
        $dataService = new PDOService($connectionString, $user, $password);

        parent::__construct($name, $dataService);
    }
}
