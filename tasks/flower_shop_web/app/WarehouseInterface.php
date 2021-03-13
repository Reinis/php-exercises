<?php

namespace FlowerShopWeb;

interface WarehouseInterface
{
    public function getFlowerByName(string $name): Flower;
}
