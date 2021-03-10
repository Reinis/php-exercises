<?php

namespace RaceTrack;

class Race
{
    private Track $track;
    private Racers $racers;

    public function __construct(Track $track, Racers $racers)
    {
        $this->track = $track;
        $this->racers = $racers;
    }

    public function start(): void
    {
        while ($this->isRacing()) {
            foreach ($this->racers as $racer) {
                // Move only the racers still in the race
                if ($racer->getProgress() < $this->track->getLength()) {
                    $racer->move();
                }
            }
        }
    }

    private function isRacing(): bool
    {
        foreach ($this->racers as $racer) {
            if ($racer->getProgress() < $this->track->getLength()) {
                return true;
            }
        }

        return false;
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
