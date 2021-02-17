<?php declare(strict_types=1);

// Write a program to produce the sum of 1, 2, 3, ..., to 100. Store 1 and 100
// in variables lower bound and upper bound, so that we can change their
// values easily. Also compute and display the average. The output shall look like:
//
// The sum of 1 to 100 is 5050
// The average is 50.5
$start = 1;
$end = 100;

function sequenceSum(int $start, int $end): int
{
    return ($end - $start + 1) * ($start + $end) / 2;
}

function sequenceAvg(int $start, int $end): float
{
    return ($start + $end) / 2;
}

$sum = sequenceSum($start, $end);
$avg = sequenceAvg($start, $end);

echo "The sum of {$start} to {$end} is {$sum}\n";
echo "The average is {$avg}\n";
