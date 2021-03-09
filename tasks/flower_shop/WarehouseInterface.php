<?php

namespace FlowerShop;

interface WarehouseInterface
{
    public function getFlowerByName(string $name): Flower;
}
