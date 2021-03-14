<?php

namespace RaceTrack;

class Race
{
    private Track $track;
    private Racers $racers;
    private RaceProgress $display;

    public function __construct(Track $track, Racers $racers)
    {
        $this->track = $track;
        $this->racers = $racers;
        $this->display = new RaceProgress($track, $racers);
    }

    public function start(bool $displayProgress = false): void
    {
        if ($displayProgress) {
            $this->display->print($this->racers, false);
        }

        while ($this->isRacing()) {
            $this->advanceRacers();

            if ($displayProgress) {
                $this->display->print($this->racers);
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
}
