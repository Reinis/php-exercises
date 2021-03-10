<?php

namespace RaceTrack;

class RaceProgress
{
    private const RACER = '🏎';
    private const TILE = '.';
    private const FINISH = '|';

    private const CONTROL_SEQUENCE_INTRODUCER = "\e[";
    private const MOVE_CURSOR_UP = "A";

    private string $lane;

    public function __construct(Track $track, Racers $racers)
    {
        $trackLength = $track->getLength();
        $laneLength = $track->getLength() + $racers->getLargestSpeed();
        $lane = str_repeat(self::TILE, $laneLength) . PHP_EOL;

        $this->lane = substr_replace($lane, self::FINISH, $trackLength, 1);
    }

    public function print(Racers $racers, bool $moveCursor = true): void
    {
        if ($moveCursor) {
            $this->moveCursorToFirstLane($racers);
        }

        foreach ($racers as $racer) {
            printf("%10s:", $racer->getName());
            echo substr_replace($this->lane, self::RACER, $racer->getProgress(), 1);
        }

        echo PHP_EOL;
        usleep(200_000);
    }

    private function moveCursorToFirstLane(Racers $racers): void
    {
        echo self::CONTROL_SEQUENCE_INTRODUCER . (count($racers) + 1) . self::MOVE_CURSOR_UP;
    }
}
