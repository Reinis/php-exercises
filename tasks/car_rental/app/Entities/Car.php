<?php

namespace CarRental\Entities;

use InvalidArgumentException;
use JsonSerializable;

class Car implements JsonSerializable
{
    public const UNAVAILABLE = -1;
    public const AVAILABLE = 0;
    public const RENTED = 1;

    private int $id;
    private string $name;
    private string $model;
    private float $fuelEconomy;
    private int $price;
    private int $status;

    /**
     * @var int[]
     */
    private array $actions = [
        'rent' => self::RENTED,
        'return' => self::AVAILABLE,
    ];

    /**
     * @var string[]
     */
    private array $states = [
        self::AVAILABLE => 'available',
        self::RENTED => 'rented',
        self::UNAVAILABLE => 'unavailable',
    ];

    public function __construct(
        int $id = 0,
        string $name = "",
        string $model = "",
        float $fuelEconomy = -1,
        int $price = -1,
        int $status = self::UNAVAILABLE
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
        $this->fuelEconomy = $fuelEconomy;
        $this->price = $price;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getFuelEconomy(): float
    {
        return $this->fuelEconomy;
    }

    public function setFuelEconomy(float $fuelEconomy): void
    {
        $this->fuelEconomy = $fuelEconomy;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function changeStatus(string $action): void
    {
        if ($this->getStatus() === $this->actions[$action]) {
            $message = "Can't '{$action}' a car with status '{$this->getStatusText()}'";
            throw new InvalidArgumentException($message);
        }

        $this->setStatus($this->actions[$action]);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getStatusText(): string
    {
        return $this->states[$this->getStatus()];
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'model' => $this->getModel(),
            'fuelEconomy' => $this->getFuelEconomy(),
            'price' => $this->getPrice(),
            'status' => $this->getStatus(),
        ];
    }
}
