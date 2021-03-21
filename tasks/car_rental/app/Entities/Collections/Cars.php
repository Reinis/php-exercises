<?php

namespace CarRental\Entities\Collections;

use ArrayIterator;
use CarRental\Entities\Car;
use InvalidArgumentException;
use IteratorAggregate;
use JsonSerializable;

class Cars implements IteratorAggregate, JsonSerializable
{
    /**
     * @var Car[]
     */
    private array $cars;

    public function __construct(Car ...$cars)
    {
        foreach ($cars as $car) {
            $this->addCar($car);
        }
    }

    public function addCar(Car $car, bool $autoId = false): void
    {
        if (!isset($this->cars[$car->getId()])) {
            $this->cars[$car->getId()] = $car;
            return;
        }

        if ($autoId) {
            $id = max(array_keys($this->cars)) + 1;
            $car->setId($id);
            $this->cars[$id] = $car;
            return;
        }

        throw new InvalidArgumentException("Car id already exists: {$car->getId()}");
    }

    /**
     * @return ArrayIterator|Car[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->cars);
    }

    public function getById(string $id): Car
    {
        if (!isset($this->cars[$id])) {
            throw new InvalidArgumentException("Car id not found: {$id}");
        }

        return $this->cars[$id];
    }

    public function jsonSerialize(): array
    {
        return array_values($this->cars);
    }
}
