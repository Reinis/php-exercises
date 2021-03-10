<?php

namespace RaceTrack;

use Exception;

class Car implements Movable
{
    private string $name;
    private int $minSpeed;
    private int $maxSpeed;

    public function __construct(string $name, int $minSpeed, int $maxSpeed)
    {
        $this->name = $name;
        $this->minSpeed = $minSpeed;
        $this->maxSpeed = $maxSpeed;
    }

    public function move(): int
    {
        try {
            return random_int($this->minSpeed, $this->maxSpeed);
        } catch (Exception $e) {
            /** @noinspection RandomApiMigrationInspection */
            return rand($this->minSpeed, $this->maxSpeed);
        }
    }

    public function getId(): string
    {
        return sha1('CAR_' . $this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
