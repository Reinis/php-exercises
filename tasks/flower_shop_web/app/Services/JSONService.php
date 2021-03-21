<?php

namespace FlowerShopWeb\Services;

use Exception;
use FlowerShopWeb\Entities\Product;
use InvalidArgumentException;
use JsonCollectionParser\Parser;

class JSONService implements DataServiceInterface
{

    private const STORAGE_DIR = 'storage';
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $name
     * @return Product
     * @throws Exception
     */
    public function getProductByName(string $name): Product
    {
        $filename = implode(DIRECTORY_SEPARATOR, [self::STORAGE_DIR, $this->fileName]);
        $parser = new Parser();
        $product = null;

        $parser->parse(
            $filename,
            function (array $item) use ($parser, &$product, $name) {
                if (isset($item['name']) && $item['name'] === $name) {
                    $product = new Product();
                    $product->setId($item['id']);
                    $product->setName($item['name']);
                    $product->setPrice($item['price']);
                    $product->setAmount($item['amount']);
                    $parser->stop();
                }
            }
        );

        if ($product === null) {
            throw new InvalidArgumentException("Product not found: {$name}");
        }

        return $product;
    }
}
