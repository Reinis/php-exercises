<?php

namespace RaceTrack;

class RaceProgress
{
    private const RACER = '🏎';
    private const TILE = '.';
    private const FINISH = '|';
    private const MAX_RACER_SPEED = 10;

    private const CONTROL_SEQUENCE_INTRODUCER = "\e[";
    private const MOVE_CURSOR_UP = "A";

    private int $trackLength;
    private int $laneLength;

    public function __construct(Track $track)
    {
        $this->trackLength = $track->getLength();
        $this->laneLength = $track->getLength() + self::MAX_RACER_SPEED;
    }

    public function print(Racers $racers, bool $moveCursor = true): void
    {
        $lane = str_repeat(self::TILE, $this->laneLength) . PHP_EOL;
        $lane = substr_replace($lane, self::FINISH, $this->trackLength, 1);

        if ($moveCursor) {
            $this->moveCursorToFirstLane($racers);
        }

        foreach ($racers as $racer) {
            printf("%10s:", $racer->getName());
            echo substr_replace($lane, self::RACER, $racer->getProgress(), 1);
        }

        echo PHP_EOL;
        usleep(200_000);
    }

    private function moveCursorToFirstLane(Racers $racers): void
    {
        echo self::CONTROL_SEQUENCE_INTRODUCER . (count($racers) + 1) . self::MOVE_CURSOR_UP;
    }
}
