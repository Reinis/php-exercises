<?php

/**
 * For this exercise, you will design a set of classes that work together to
 * simulate a car's fuel gauge and odometer. The classes you will design are
 * the following:
 *
 * The FuelGauge Class: This class will simulate a fuel gauge.
 * Its responsibilities are as follows:
 *
 * To know the car’s current amount of fuel, in liters.
 * To report the car’s current amount of fuel, in liters.
 * To be able to increment the amount of fuel by 1 liter. This simulates
 * putting fuel in the car. ( The car can hold a maximum of 70 liters.)
 * To be able to decrement the amount of fuel by 1 liter, if the amount of
 * fuel is greater than 0 liters. This simulates burning fuel as the car runs.
 *
 * The Odometer Class: This class will simulate the car’s odometer.
 * Its responsibilities are as follows:
 *
 * To know the car’s current mileage.
 * To report the car’s current mileage.
 * To be able to increment the current mileage by 1 kilometer. The maximum
 * mileage the odometer can store is 999,999 kilometer. When this amount is
 * exceeded, the odometer resets the current mileage to 0.
 * To be able to work with a FuelGauge object. It should decrease the
 * FuelGauge object’s current amount of fuel by 1 liter for every
 * 10 kilometers traveled. (The car’s fuel economy is 10 kilometers per liter.)
 *
 * Demonstrate the classes by creating instances of each. Simulate filling the
 * car up with fuel, and then run a loop that increments the odometer until
 * the car runs out of fuel. During each loop iteration, print the car’s
 * current mileage and amount of fuel.
 */

declare(strict_types=1);

namespace Car;

class FuelGauge
{
    public const TANK_CAPACITY = 70;

    private int $fuel = 0;

    public function read(): int
    {
        return $this->fuel;
    }

    public function addFuel(): void
    {
        if ($this->fuel < self::TANK_CAPACITY) {
            $this->fuel++;
        }
    }

    public function burnFuel(): void
    {
        if ($this->fuel > 0) {
            $this->fuel--;
        }
    }
}


class Odometer
{
    private const COUNTER_LIMIT = 999_999;
    private const FUEL_ECONOMY = 10;

    private int $mileage = 0;
    private FuelGauge $fuelGauge;

    public function __construct(FuelGauge $fuelGauge)
    {
        $this->fuelGauge = $fuelGauge;
    }

    public function read(): int
    {
        return $this->mileage;
    }

    public function increaseMileage(): void
    {
        if ($this->mileage < self::COUNTER_LIMIT) {
            $this->mileage++;
        } else {
            $this->mileage = 0;
        }

        // Decrement the fuel gauge
        if ($this->mileage % self::FUEL_ECONOMY === 0) {
            $this->fuelGauge->burnFuel();
        }
    }
}


function drawProgress(int $counter, int $fuel, int $mileage = 0): void
{
    $spinner = ['◐', '◓', '◑', '◒'];

    echo GO_TO_LINE_START
        . GO_ONE_LINE_UP
        . 'Fuel: '
        . str_repeat('█', $fuel)
        . str_repeat(' ', FuelGauge::TANK_CAPACITY - $fuel)
        . sprintf(' %2d/%2d ', $fuel, FuelGauge::TANK_CAPACITY)
        . $spinner[$counter % 4]
        . PHP_EOL
        . sprintf('Mileage: %6dkm', $mileage);
}


const DISABLE_CURSOR = "\e[?25l";
const ENABLE_CURSOR = "\e[?25h";
const GO_TO_LINE_START = "\r";
const GO_ONE_LINE_UP = "\e[1A";


$fuelGauge = new FuelGauge();
$odometer = new Odometer($fuelGauge);

// Fill the tank
echo DISABLE_CURSOR;

for ($i = 0; $i < FuelGauge::TANK_CAPACITY + 30; $i++) {
    $fuelGauge->addFuel();
    usleep(100_000);

    drawProgress($i, $fuelGauge->read());
}

// Drive
while ($fuelGauge->read() > 0) {
    $odometer->increaseMileage();
    usleep(10_000);

    $mileage = $odometer->read();
    drawProgress($mileage, $fuelGauge->read(), $mileage);
}

echo ENABLE_CURSOR . PHP_EOL;
