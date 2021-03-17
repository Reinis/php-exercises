<?php

namespace FlowerShopWeb;

use PDO;

class Warehouse1 extends Warehouse
{
    public function __construct(string $name, string $connectionString, string $user, string $password)
    {
        $flowers = new Flowers();

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $connection = new PDO($connectionString, $user, $password, $options);
        $data = $connection->query("select * from `Warehouse1`");
        $connection = null;

        foreach ($data as ['name' => $flower, 'amount' => $amount]) {
            $flowers->addFlower(new Flower($flower, $amount));
        }

        parent::__construct($name, $flowers);
    }
}
