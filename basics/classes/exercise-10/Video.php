<?php

namespace VideoStore;

use InvalidArgumentException;

class Video
{
    private string $title;
    /**
     * @var int[]
     */
    private array $ratings = [];
    private bool $isCheckedOut = false;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function __toString(): string
    {
        return sprintf(
            "%s, rating = %0.1f, available = %s",
            $this->title,
            $this->getAvgRating(),
            $this->isCheckedOut ? 'no' : 'yes'
        );
    }

    public function getAvgRating(): float
    {
        if (count($this->ratings) === 0) {
            return 0;
        }

        return array_sum($this->ratings) / count($this->ratings);
    }

    public function checkout(): void
    {
        if ($this->isCheckedOut) {
            throw new \InvalidArgumentException("Video not available");
        }

        $this->isCheckedOut = true;
    }

    public function return(): void
    {
        $this->isCheckedOut = false;
    }

    public function rate(int $rating): void
    {
        if ($rating < 1 || $rating > 5) {
            throw new InvalidArgumentException("Invalid rating: {$rating}");
        }

        $this->ratings[] = $rating;
    }
}
