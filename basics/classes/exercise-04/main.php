<?php

declare(strict_types=1);

namespace Movie;

require_once 'Movie.php';
require_once 'Functions.php';


$movies = [
    new Movie("Casino Royale", "Eon Productions", "PG13"),
    new Movie("Glass", "Buena Vista International", "PG13"),
    new Movie("Spider-Man: Into the Spider-Verse", "Columbia Pictures", "PG"),
];

echo "'PG' movies:\n";

foreach (getPG($movies) as $movie) {
    printf("'%s', produced by %s\n", $movie->getTitle(), $movie->getStudio());
}
