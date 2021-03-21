<?php

namespace FlowerShopWeb\Services;

use FlowerShopWeb\Entities\Product;
use InvalidArgumentException;
use PDO;
use PDOException;

class PDOService implements DataServiceInterface
{
    private PDO $connection;

    public function __construct(string $connectionString, string $user, string $password)
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new PDO($connectionString, $user, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getProductByName(string $name): Product
    {
        $statement = $this->connection->prepare("select * from `Warehouse1` where name = ?");
        $statement->setFetchMode(PDO::FETCH_CLASS, Product::class);
        $statement->execute([$name]);
        $product = $statement->fetch();

        if ($product === false) {
            throw new InvalidArgumentException("Product not found: {$name}");
        }

        return $product;
    }
}
