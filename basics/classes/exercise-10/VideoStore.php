<?php

namespace VideoStore;

use InvalidArgumentException;

class VideoStore
{
    /**
     * @var Video[]
     */
    private array $inventory = [];

    public function addVideo(string $title): void
    {
        if ($title === '') {
            throw new InvalidArgumentException("Invalid title.");
        }

        $this->inventory[$title] = new Video($title);
    }

    public function checkOutVideo(string $title): void
    {
        if (!isset($this->inventory[$title])) {
            throw new InvalidArgumentException("Video not found.");
        }

        $this->inventory[$title]->checkout();
    }

    public function returnVideo(string $title): void
    {
        if (!isset($this->inventory[$title])) {
            throw new InvalidArgumentException("Video not found.");
        }

        $this->inventory[$title]->return();
    }

    public function rateVideo(string $title, int $rating): void
    {
        if (!isset($this->inventory[$title])) {
            throw new InvalidArgumentException("Video not found.");
        }

        $this->inventory[$title]->rate($rating);
    }

    public function listVideos(): string
    {
        return implode("\n", $this->inventory);
    }

    public function getTitles(): array
    {
        return array_keys($this->inventory);
    }
}
