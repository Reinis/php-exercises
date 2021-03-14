<?php

declare(strict_types=1);

namespace RaceTrack;

require_once 'Movable.php';
require_once 'Car.php';
require_once 'Racer.php';
require_once 'Racers.php';
require_once 'Track.php';
require_once 'RaceProgress.php';
require_once 'Race.php';

$track = new Track(70);
$racers = new Racers(
    new Car("Auto1", 2, 5, 1),
    new Car('Auto2', 3, 5, 3),
    new Car('Auto3', 1, 7, 5),
);

$race = new Race($track, $racers);
$view = new RaceProgress($race);
$view->start();
$view->showLeaderboard();
