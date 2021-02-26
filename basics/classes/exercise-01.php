<?php

/**
 * Create a class Product that represents a product sold in a shop. A product
 * has a price, amount and name.
 *
 * The class should have:
 *
 * A constructor `Product(string name, double price_at_start, int amount_at_start)`
 * A `function print_product()` that prints a product in the following form:
 *
 * Banana, price 1.1, amount 13
 *
 * Test your code by creating a class with main method and add three products
 * there:
 *
 * "Logitech mouse", 70.00 EUR, 14 units
 * "iPhone 5s", 999.99 EUR, 3 units
 * "Epson EB-U05", 440.46 EUR, 1 units
 *
 * Print out information about them.
 *
 * Add new behaviour to the Product class:
 *
 * possibility to change quantity
 * possibility to change price
 *
 * Reflect your changes in a working application.
 */

declare(strict_types=1);

namespace Product;

use NumberFormatter;

class Product
{
    private const LOCALE = 'en_US';
    private const CURRENCY = 'EUR';

    private string $name;
    private float $price;
    private int $amount;
    private NumberFormatter $moneyFormatter;

    public function __construct(string $name, float $price, int $amount)
    {
        $this->name = $name;
        $this->price = $price;
        $this->amount = $amount;
        $this->moneyFormatter = numfmt_create(self::LOCALE, NumberFormatter::CURRENCY);
    }

    public function printProduct(): void
    {
        $priceString = $this->moneyFormatter->formatCurrency(
            $this->price,
            self::CURRENCY
        );
        echo "{$this->name}, price {$priceString}, amount {$this->amount}\n";
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}


class Shop
{
    private string $name;
    private array $products = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function main(array $products): void
    {
        // Add products
        $this->addProducts($products);

        // Print products
        foreach ($this->products as $product) {
            $product->printProduct();
        }

        // Discount 20% and double the inventory
        $discount = 0.20;
        $inventoryIncrease = 2;

        echo "\nDiscount "
            . $discount * 100
            . "% and change inventory by a factor of {$inventoryIncrease}\n\n";

        foreach ($this->products as $product) {
            $product->setPrice($product->getPrice() * (1 - $discount));
            $product->setAmount($product->getAmount() * $inventoryIncrease);
            $product->printProduct();
        }
    }

    public function addProducts(array $products): void
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }
}


$products = [
    new Product("Logitech mouse", 70.00, 14),
    new Product("iPhone 5s", 999.99, 3),
    new Product("Epson EB-U05", 440.46, 1),
];


$shop = new Shop('Codelex');
$shop->main($products);
