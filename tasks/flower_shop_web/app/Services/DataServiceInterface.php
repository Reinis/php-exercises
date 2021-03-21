<?php

namespace FlowerShopWeb\Services;

use FlowerShopWeb\Entities\Product;

interface DataServiceInterface
{
    public function getProductByName(string $name): Product;
}
