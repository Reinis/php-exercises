<?php

namespace RaceTrack;

use Exception;

class Car implements Movable
{
    private string $name;
    private int $minSpeed;
    private int $maxSpeed;
    private int $largestSpeed = 10;
    private int $crashRate;

    public function __construct(string $name, int $minSpeed, int $maxSpeed, int $crashRate)
    {
        $this->name = $name;
        $this->minSpeed = max($minSpeed, 1);
        $this->maxSpeed = min($maxSpeed, $this->largestSpeed);
        $this->crashRate = $crashRate;
    }

    public function move(): int
    {
        if ($this->hasCrashed()) {
            return -1;
        }

        try {
            return random_int($this->minSpeed, $this->maxSpeed);
        } catch (Exception $e) {
            return $this->minSpeed;
        }
    }

    private function hasCrashed(): bool
    {
        try {
            $number = random_int(1, 100);
        } catch (Exception $e) {
            $number = 100;
        }

        return $number < $this->crashRate;
    }

    public function getId(): string
    {
        return sha1('CAR_' . $this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLargestSpeed(): int
    {
        return $this->largestSpeed;
    }
}
