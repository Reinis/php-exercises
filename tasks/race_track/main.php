<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use RaceTrack\Car;
use RaceTrack\Race;
use RaceTrack\RaceConsoleView;
use RaceTrack\Racers;
use RaceTrack\Track;


$track = new Track(70);
$racers = new Racers(
    new Car("Auto1", 2, 5, 1),
    new Car('Auto2', 3, 5, 3),
    new Car('Auto3', 1, 7, 5),
);

$race = new Race($track, $racers);
$view = new RaceConsoleView($race);
$view->start();
$view->showLeaderboard();
