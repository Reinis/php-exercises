<?php

namespace RaceTrack;

use ArrayIterator;
use Countable;
use IteratorAggregate;

class Racers implements IteratorAggregate, Countable
{
    /**
     * @var Racer[]
     */
    private array $racers;
    private int $largestSpeed;

    public function __construct(Movable ...$racers)
    {
        foreach ($racers as $racer) {
            $this->addRacer($racer);
        }

        $this->largestSpeed = max(
            array_map(
                static fn(Movable $racer): int => $racer->getLargestSpeed(),
                $racers
            )
        );
    }

    private function addRacer(Movable $racer): void
    {
        $this->racers[$racer->getId()] = new Racer($racer);
    }

    /**
     * @return ArrayIterator|Racer[]
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->racers);
    }

    public function sort(): void
    {
        uasort(
            $this->racers,
            static function (Racer $a, Racer $b): int {
                if ($a->getTime() === $b->getTime()) {
                    // Sort descending by progress
                    return $b->getProgress() <=> $a->getProgress();
                }
                // Sort ascending by time
                return $a->getTime() <=> $b->getTime();
            }
        );
    }

    public function count(): int
    {
        return count($this->racers);
    }

    public function getLargestSpeed(): int
    {
        return $this->largestSpeed;
    }
}
