<?php

namespace RaceTrack;

interface Movable
{
    public function getId(): string;

    public function getName(): string;

    public function getLargestSpeed(): int;

    /**
     * @throws RacerCrashException
     */
    public function move(): int;
}
