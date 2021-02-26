<?php

/**
 * Write a method named `swap_points` that accepts two Points as parameters
 * and swaps their x/y values.
 *
 * Consider the following example code that calls swapPoints:
 *
 * $p1 = new Point(5, 2);
 * $p2 = new Point(-3, 6);
 * swap_points(p1, p2);
 * echo "(" . p1.x . ", " . p1.y . ")";
 * echo "(" . p2.x . ", " . p2.y . ")";
 *
 * The output produced from the above code should be:
 *
 * (-3, 6)
 * (5, 2)
 */

declare(strict_types=1);

namespace Point;

class Point
{
    public int $x;
    public int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}


function swapPoints(Point $p1, Point $p2): void
{
    $x = $p1->x;
    $y = $p1->y;

    $p1->x = $p2->x;
    $p1->y = $p2->y;
    $p2->x = $x;
    $p2->y = $y;
}


$p1 = new Point(5, 2);
$p2 = new Point(-3, 6);

echo "Points:\n";
echo "({$p1->x}, {$p1->y})\n";
echo "({$p2->x}, {$p2->y})\n";

swapPoints($p1, $p2);

echo "Swapped points:\n";
echo "({$p1->x}, {$p1->y})\n";
echo "({$p2->x}, {$p2->y})\n";
