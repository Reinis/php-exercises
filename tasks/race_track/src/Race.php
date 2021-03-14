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
            if ($this->isActive($racer)) {
                return true;
            }
        }

        return false;
    }

    private function isActive(Racer $racer): bool
    {
        return !$racer->isCrashed() && $racer->getProgress() < $this->track->getLength();
    }

    private function advanceRacers(): void
    {
        foreach ($this->racers as $racer) {
            // Move only the racers still in the race
            if ($this->isActive($racer)) {
                $racer->move();
            }
        }
    }

    public function getLeaderboard(): Racers
    {
        $this->racers->sort();

        return $this->racers;
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
