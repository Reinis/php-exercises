<?php

namespace RaceTrack;

class Racer
{
    private Movable $racer;
    private int $progress = 0;
    private int $time = 0;

    public function __construct(Movable $racer)
    {
        $this->racer = $racer;
    }

    public function getName(): string
    {
        return $this->racer->getName();
    }

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function move(): void
    {
        $this->progress += $this->racer->move();
        $this->time++;
    }

    public function getTime(): int
    {
        return $this->time;
    }
}
