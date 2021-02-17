<?php

// Modify the example program to compute the position of an object after
// falling for 10 seconds, outputting the position in meters. The formula
// in Math notation is:
// x(t) = 0.5*at^2 + v_i*t + x_i
// a = -9.81 m/s^2
// t = 10 s
// v_i = 0 m/s
// x_i = 0 m
//
// Note: The correct value is -490.5m.
function finalPosition(
    float $initialPosition,
    float $initialVelocity,
    float $acceleration,
    float $time
): float
{
    return $acceleration * ($time ** 2) / 2 + $initialVelocity * $time + $initialPosition;
}

$time = 10; // s
$acceleration = -9.81; // m/s^2
$initialVelocity = 0; // m/s
$initialPosition = 0; // m

$endPosition = finalPosition($initialPosition, $initialVelocity, $acceleration, $time);

echo "Final position: {$endPosition}m" . PHP_EOL;
