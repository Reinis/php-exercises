<?php

declare(strict_types=1);

namespace Survey;

require_once 'Survey.php';


$surveyed = 12467;
$purchasedEnergyDrinks = 0.14;
$preferCitrusDrinks = 0.64;

$survey = new Survey($surveyed, $purchasedEnergyDrinks, $preferCitrusDrinks);

echo "Total number of people surveyed " . $surveyed . ".\n";
echo "Approximately " . $survey->getEnergyDrinkerCount() . " bought at least one energy drink.\n";
echo $survey->getCitrusLoverCount() . " of those prefer citrus flavored energy drinks.\n";
