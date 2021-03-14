<?php

namespace RaceTrack;

use Generator;

class Race
{
    private Track $track;
    private Racers $racers;

    public function __construct(Track $track, Racers $racers)
    {
        $this->track = $track;
        $this->racers = $racers;
    }

    public function start(bool $displayProgress = false): Generator
    {
        if ($displayProgress) {
            yield $this->racers;
        }

        while ($this->isRacing()) {
            $this->advanceRacers();

            if ($displayProgress) {
                yield $this->racers;
            }
        }
    }

    private function isRacing(): bool
    {
        foreach ($this->racers as $racer) {
            if (!$racer->isCrashed() && $racer->getProgress() < $this->track->getLength()) {
                return true;
            }
        }

        return false;
    }

    private function advanceRacers(): void
    {
        foreach ($this->racers as $racer) {
            // Move only the racers still in the race
            if (!$racer->isCrashed() && $racer->getProgress() < $this->track->getLength()) {
                $racer->move();
            }
        }
    }

    public function getLeaderboard(): string
    {
        $result = "\nLeaderboard:\n";
        $result .= "Place Name       Time Progress\n";
        $position = 1;

        $this->racers->sort();

        foreach ($this->racers as $racer) {
            $result .= sprintf(
                "%4d. %-10s %4d %d\n",
                $position++,
                $racer->getName(),
                $racer->getTime(),
                $racer->getProgress()
            );
        }

        return $result;
    }

    public function getTrack(): Track
    {
        return $this->track;
    }

    public function getRacers(): Racers
    {
        return $this->racers;
    }
}
