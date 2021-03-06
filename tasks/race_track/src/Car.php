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
            throw new RacerCrashException("{$this->name} has crashed!");
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
            $number = random_int(0, 99);
        } catch (Exception $e) {
            $number = 99;
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
