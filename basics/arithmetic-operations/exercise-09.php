<?php declare(strict_types=1);

// Write a program that calculates and displays a person's body mass index (BMI).
// A person's BMI is calculated with the following formula:
//
// BMI = weight x 703 / height ^ 2
//
// Where weight is measured in pounds and height is measured in inches.
//
// Display a message indicating whether the person has optimal weight, is
// underweight, or is overweight. A sedentary person's weight is considered
// optimal if his or her BMI is between 18.5 and 25. If the BMI is less than
// 18.5, the person is considered underweight. If the BMI value is greater than
// 25, the person is considered overweight.
//
// Your program must accept metric units.

const KG_TO_POUNDS = 1 / 0.45359237;
const CM_TO_INCHES = 1 / 2.54;

const BMI_LOWER_BOUND = 18.5;
const BMI_UPPER_BOUND = 25;

// [weight] = lb (pounds)
// [height] = in (inches)
function calculateBmi(float $weight, float $height)
{
    return $weight * 703 / $height ** 2;
}

// [weight] = kg
// [height] = cm
function getBmi(float $weight, float $height)
{
    $weight = $weight * KG_TO_POUNDS;
    $height = $height * CM_TO_INCHES;

    return calculateBmi($weight, $height);
}

$weight = readline('-> Weight (kg): ');

if (!is_numeric($weight) or (float)$weight <= 0.0) {
    echo 'Error: Expected a positive number, but got: ' . $weight . PHP_EOL;
    exit(1);
}

$height = readline('-> Height (cm): ');

if (!is_numeric($height) or (float)$height <= 0.0) {
    echo 'Error: Expected a positive number, but got: ' . $height . PHP_EOL;
    exit(1);
}

$bmi = getBmi((float)$weight, (float)$height);

printf('BMI = %.2f', $bmi);

if ($bmi < BMI_LOWER_BOUND) {
    printf(' (<%.1f = underweight)', BMI_LOWER_BOUND);
} elseif ($bmi > BMI_UPPER_BOUND) {
    printf(' (>%.1f = overweight)', BMI_UPPER_BOUND);
} else {
    printf(' (%.1f <= optimal <= %.1f)', BMI_LOWER_BOUND, BMI_UPPER_BOUND);
}

echo PHP_EOL;
