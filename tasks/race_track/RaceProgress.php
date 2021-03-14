<?php

namespace RaceTrack;

use Generator;

class RaceProgress
{
    private const RACER = '🏎';
    private const CRASHED = '💥';
    private const TILE = '.';
    private const FINISH = '|';

    private const CONTROL_SEQUENCE_INTRODUCER = "\e[";
    private const MOVE_CURSOR_UP = "A";

    private string $lane;
    private Race $race;

    public function __construct(Race $race)
    {
        $this->race = $race;
        $trackLength = $race->getTrack()->getLength();
        $laneLength = $race->getTrack()->getLength() + $race->getRacers()->getLargestSpeed();
        $lane = str_repeat(self::TILE, $laneLength) . PHP_EOL;

        $this->lane = substr_replace($lane, self::FINISH, $trackLength, 1);
    }

    public function start(): void
    {
        $game = $this->race->start(true);
        $this->displayRacers($game->current(), false);
        $game->next();

        $remaining = static fn(Generator $steps): Generator => yield from $steps;

        foreach ($remaining($game) as $step) {
            $this->displayRacers($step);
        }
    }

    public function displayRacers(Racers $racers, bool $moveCursor = true): void
    {
        if ($moveCursor) {
            $this->moveCursorToFirstLane($racers);
        }

        foreach ($racers as $racer) {
            $crashed = $racer->isCrashed();

            printf("%10s:", $racer->getName());
            echo substr_replace(
                $this->lane,
                $crashed ? self::CRASHED : self::RACER,
                $racer->getProgress(),
                $crashed ? 2 : 1
            );
        }

        echo PHP_EOL;
        usleep(200_000);
    }

    private function moveCursorToFirstLane(Racers $racers): void
    {
        echo self::CONTROL_SEQUENCE_INTRODUCER . (count($racers) + 1) . self::MOVE_CURSOR_UP;
    }

    public function showLeaderboard(): void
    {
        $result = "\nLeaderboard:\n";
        $result .= "Place Name       Time Progress\n";
        $position = 1;

        $racers = $this->race->getLeaderboard();

        foreach ($racers as $racer) {
            $result .= sprintf(
                "%4d. %-10s %4d %d\n",
                $position++,
                $racer->getName(),
                $racer->getTime(),
                $racer->getProgress()
            );
        }

        echo $result;
    }
}
