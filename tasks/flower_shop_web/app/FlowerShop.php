<?php

namespace FlowerShopWeb;

use InvalidArgumentException;

class FlowerShop
{
    // Discount %
    private const DISCOUNT_FEMALE = 20;
    private const DISCOUNT_MALE = 0;

    /**
     * @var WarehouseInterface[]
     */
    private array $warehouses;
    private Flowers $flowers;
    private array $prices;

    public function __construct(WarehouseInterface ...$warehouses)
    {
        foreach ($warehouses as $warehouse) {
            $this->warehouses[$warehouse->getName()] = $warehouse;
        }

        $this->flowers = new Flowers();
    }

    public function setPrices(array $prices): void
    {
        $this->prices = $prices;
    }

    public function stockFlowers(Flowers $flowers): string
    {
        $messages = '';

        foreach ($flowers as $targetFlower) {
            $name = $targetFlower->getName();
            $currentFlower = new Flower($name, 0);

            foreach ($this->warehouses as $warehouse) {
                try {
                    $warehouseFlower = $warehouse->getFlowerByName($name);
                    $available = $warehouseFlower->getAmount();

                    if ($available > $targetFlower->getAmount()) {
                        $warehouseFlower->subtractAmount($targetFlower->getAmount());
                        $currentFlower->addAmount($targetFlower->getAmount());
                        $targetFlower->setAmount(0);
                        break;
                    }

                    $warehouseFlower->setAmount(0);
                    $currentFlower->addAmount($available);
                    $targetFlower->subtractAmount($available);
                } catch (InvalidArgumentException $exception) {
                    $messages .= $exception->getMessage() . PHP_EOL;
                    continue;
                }
            }

            $this->flowers->addFlower($currentFlower);
        }

        return $messages;
    }

    public function isAvailable(string $name): bool
    {
        try {
            $flower = $this->flowers->getFlowerByName($name);

            return $flower->getAmount() > 0;
        } catch (InvalidArgumentException $exception) {
            return false;
        }
    }

    public function numAvailable(string $name): int
    {
        try {
            $flower = $this->flowers->getFlowerByName($name);

            return $flower->getAmount();
        } catch (InvalidArgumentException $exception) {
            return 0;
        }
    }

    public function list(): string
    {
        $items = '';

        foreach ($this->flowers as $flower) {
            $price = $this->prices[$flower->getName()];
            $items .= sprintf("%-10s %10d %5d\n", $flower->getName(), $flower->getAmount(), $price);
        }

        return $items;
    }

    public function listWeb(): string
    {
        $items = '<table><tr><th>Name</th><th>Amount</th><th>Price</th></tr>';

        $formatString = "<tr><td>%-10s</td> <td>%10d</td> <td>%5d</td></tr>\n";
        foreach ($this->flowers as $flower) {
            $price = $this->prices[$flower->getName()];
            $items .= sprintf($formatString, $flower->getName(), $flower->getAmount(), $price);
        }

        $items .= '</table>';

        return $items;
    }

    public function buyFlowers(string $name, int $amount, string $customerGender): string
    {
        $discount = $customerGender === 'male' ? self::DISCOUNT_MALE : self::DISCOUNT_FEMALE;
        $discount = (100 - $discount) / 100;
        $price = $this->getPrice($name);
        $total = round($amount * $price * $discount);

        $invoice = "\nInvoice:\n";
        $formatString = "%8s: %s\n";
        $invoice .= sprintf($formatString, 'Flower', $name);
        $invoice .= sprintf($formatString, 'Price', $price);
        $invoice .= sprintf($formatString, 'Amount', $amount);
        $invoice .= sprintf($formatString, 'Total', $total);

        return $invoice;
    }

    private function getPrice(string $name): int
    {
        if (!isset($this->prices[$name])) {
            throw new InvalidArgumentException("Flower not available in the shop!");
        }

        return $this->prices[$name];
    }

    public function buyFlowersWeb(string $name, int $amount, string $customerGender): string
    {
        $discount = $customerGender === 'male' ? self::DISCOUNT_MALE : self::DISCOUNT_FEMALE;
        $discount = (100 - $discount) / 100;
        $price = $this->getPrice($name);
        $total = round($amount * $price * $discount);

        $invoice = "\n<h3>Invoice:</h3>\n<table>";
        $formatString = "<tr><td><strong>%8s</strong></td> <td>%s</td></tr>\n";
        $invoice .= sprintf($formatString, 'Flower', $name);
        $invoice .= sprintf($formatString, 'Price', $price);
        $invoice .= sprintf($formatString, 'Amount', $amount);
        $invoice .= sprintf($formatString, 'Total', $total);
        $invoice .= "</table>";

        return $invoice;
    }
}
