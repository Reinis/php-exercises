<?php declare(strict_types=1);

// Design a Geometry class with the following methods:
//
//    A static method that accepts the radius of a circle and returns the area
//    of the circle. Use the following formula:
//        Area = π * r * 2
//        Use Math.PI for π and r for the radius of the circle
//    A static method that accepts the length and width of a rectangle and
//    returns the area of the rectangle. Use the following formula:
//        Area = Length x Width
//    A static method that accepts the length of a triangle’s base and the triangle’s
//    height. The method should return the area of the triangle. Use the following
//    formula:
//        Area = Base x Height x 0.5
//
// The methods should display an error message if negative values are used for
// the circle’s radius, the rectangle’s length or width, or the triangle’s
// base or height.
//
// Next write a program to test the class, which displays the following menu
// and responds to the user’s selection:
//
// Geometry calculator:
//
// Calculate the Area of a Circle
// Calculate the Area of a Rectangle
// Calculate the Area of a Triangle
// Quit
// Enter your choice (1-4):
//
// Display an error message if the user enters a number outside the range of
// 1 through 4 when selecting an item from the menu.

class Geometry
{
    static function circleArea(float $radius): float
    {
        if ($radius < 0) {
            printf("Error: Expected a positive radius, but got: %f\n", $radius);
            return 0.0;
        }

        return M_PI * $radius ** 2;
    }

    static function rectangleArea(float $length, float $width): float
    {
        if ($length < 0 or $width < 0) {
            printf(
                "Error: Expected a positive length and width, but got: %f and %f\n",
                $length,
                $width
            );
            return 0.0;
        }

        return $length * $width;
    }

    static function triangleArea(float $base, float $height): float
    {
        if ($base < 0 or $height < 0) {
            printf(
                "Error: Expected a positive base and height, but got: %f and %f\n",
                $base,
                $height
            );
            return 0.0;
        }

        return $base * $height / 2;
    }
}

function getFloat(string $prompt): float
{
    do {
        $number = readline($prompt);
    } while (!is_numeric($number));

    return (float)$number;
}

while (true) {
    echo "\nGeometry Calculator\n";
    echo "1. Calculate the Area of a Circle\n";
    echo "2. Calculate the Area of a Rectangle\n";
    echo "3. Calculate the Area of a Triangle\n";
    echo "4. Quit\n";

    $choice = readline('Enter your choice (1–4): ');

    if (!ctype_digit($choice)) {
        echo "Error: Expected integer [1; 4], but got: {$choice}!\n";
        continue;
    }

    switch ((int)$choice) {
        case 1:
            $radius = getFloat('-> Radius: ');
            $area = Geometry::circleArea($radius);
            printf("\nThe area of the circle is %.2f\n", $area);
            break;
        case 2:
            $length = getFloat('-> Length: ');
            $width = getFloat('-> Width: ');
            $area = Geometry::rectangleArea($length, $width);
            printf("\nThe area of the rectangle is %.2f\n", $area);
            break;
        case 3:
            $base = getFloat('-> Base: ');
            $height = getFloat('-> Height: ');
            $area = Geometry::triangleArea($base, $height);
            printf("\nThe area of the triangle is %.2f\n", $area);
            break;
        case 4:
            exit(0);
        default:
            echo "\nError: Invalid choice!\n";
            break;
    }
}
