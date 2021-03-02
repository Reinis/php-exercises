<?php

namespace Date;

use InvalidArgumentException;

require_once 'Date.php';

$date = new Date(2021, 03, 02);

echo 'Date: ' . $date->displayDate() . PHP_EOL;

$date->setDay($date->getDay() + 1);

echo 'Tomorrow: ' . $date->displayDate() . PHP_EOL;

try {
    $date->setDay(0);
} catch (InvalidArgumentException $e) {
    echo "Caught an invalid argument for Date::setDay(): {$e->getMessage()}\n";
}

try {
    $date->setDay(33);
} catch (InvalidArgumentException $e) {
    echo "Caught another invalid argument for Date::setDay(): {$e->getMessage()}\n";
}

try {
    $date->setMonth(-1);
} catch (InvalidArgumentException $e) {
    echo "Caught an invalid argument for Date::setMonth(): {$e->getMessage()}\n";
}

try {
    $date->setMonth(36);
} catch (InvalidArgumentException $e) {
    echo "Caught another invalid argument for Date::setMonth(): {$e->getMessage()}\n";
}

$date->setMonth($date->getMonth() - 1);

echo "Previous month: {$date->getMonth()}\n";

echo "Year: {$date->getYear()}\n";

$date->setYear($date->getYear() + 1);

echo "Next year: {$date->getYear()}\n";
