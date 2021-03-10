<?php

namespace RaceTrack;

class Racer
{
    private Movable $racer;
    private int $progress = 0;
    private int $time = 0;
    private bool $crashed = false;

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
        if ($this->crashed) {
            return;
        }

        $move = $this->racer->move();

        if ($move < 0) {
            $this->crashed = true;
            return;
        }

        $this->progress += $move;
        $this->time++;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function isCrashed(): bool
    {
        return $this->crashed;
    }
}
