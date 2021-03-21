<?php

namespace FlowerShopWeb\Services;

use FlowerShopWeb\Entities\Product;
use InvalidArgumentException;

class CSVService implements DataServiceInterface
{

    private const STORAGE_DIR = 'storage';
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function getProductByName(string $name): Product
    {
        $filename = implode(DIRECTORY_SEPARATOR, [self::STORAGE_DIR, $this->fileName]);

        if (($handle = fopen($filename, 'rb')) === false) {
            throw new InvalidArgumentException("Could not open file for reading: {$this->fileName}");
        }

        $product = new Product();
        $found = false;

        /** @var string[] $data */
        while (($data = fgetcsv($handle, 1000)) !== false && $data !== null) {
            if (isset($data[0]) && count($data) >= 4 && $data[1] === $name) {
                $product->setId($data[0]);
                $product->setName($data[1]);
                $product->setPrice($data[2]);
                $product->setAmount($data[3]);
                $found = true;
                break;
            }
        }

        fclose($handle);

        if (!$found) {
            throw new InvalidArgumentException("Product not found: {$name}");
        }

        return $product;
    }
}
