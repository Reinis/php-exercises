<?php

namespace RaceTrack;

class Track
{
    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
