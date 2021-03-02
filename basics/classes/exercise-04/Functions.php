<?php

use Movie\Movie;

/**
 * @param Movie[] $movies
 * @return Movie[]
 */
function getPG(array $movies): array
{
    return array_filter(
        $movies,
        static fn(Movie $movie): bool => $movie->getRating() === 'PG'
    );
}
