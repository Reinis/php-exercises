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

    /**
     * @param Flowers $flowers
     * @return string[]
     */
    public function stockFlowers(Flowers $flowers): array
    {
        $messages = [];

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
                    $messages[] = $exception->getMessage();
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

    public function getInventory(): array
    {
        $items = [];

        foreach ($this->flowers as $flower) {
            $items[] = [
                'name' => $flower->getName(),
                'amount' => $flower->getAmount(),
                'price' => $this->prices[$flower->getName()],
            ];
        }

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

    public function getInvoice(string $name, int $amount, string $customerGender): Invoice
    {
        $discount = $customerGender === 'male' ? self::DISCOUNT_MALE : self::DISCOUNT_FEMALE;
        $discount = (100 - $discount) / 100;
        $price = $this->getPrice($name);
        $total = round($amount * $price * $discount);

        return new Invoice($name, $price, $amount, $total);
    }
}
