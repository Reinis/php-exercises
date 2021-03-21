<?php

namespace FlowerShopWeb;

use PDO;
use PDOException;

class Warehouse1 extends Warehouse
{
    public function __construct(string $name, string $connectionString, string $user, string $password)
    {
        $flowers = new Flowers();

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $connection = new PDO($connectionString, $user, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        $data = $connection->query("select * from `Warehouse1`");

        foreach ($data as $item) {
            $flowers->addFlower(new Flower($item->name, $item->amount));
        }

        parent::__construct($name, $flowers);
    }
}
