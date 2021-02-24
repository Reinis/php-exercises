<?php

declare(strict_types=1);

namespace AsciiFigure;

// Write a console program in a class named AsciiFigure that draws a figure of
// the following form, using for loops.
//
// ////////////////\\\\\\\\\\\\\\\\
// ////////////********\\\\\\\\\\\\
// ////////****************\\\\\\\\
// ////************************\\\\
// ********************************
//
// Then, modify your program using an integer class constant so that it can
// create a similar figure of any size. For instance, the diagram above has a
// size of 5. For example, the figure below has a size of 3:
//
// ////////\\\\\\\\
// ////********\\\\
// ****************
//
// And the figure below has a size of 7:
//
// ////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\
// ////////////////////********\\\\\\\\\\\\\\\\\\\\
// ////////////////****************\\\\\\\\\\\\\\\\
// ////////////************************\\\\\\\\\\\\
// ////////********************************\\\\\\\\
// ////****************************************\\\\
// ************************************************

class AsciiFigure
{
    private const STEP_SIZE = 4;

    public function draw(): void
    {
        $size = 5;
        $width = ($size - 1) * self::STEP_SIZE;

        for ($i = 0; $i < $size; $i++) {
            echo str_repeat('/', $width - $i * self::STEP_SIZE);
            echo str_repeat('*', 2 * $i * self::STEP_SIZE);
            echo str_repeat('\\', $width - $i * self::STEP_SIZE);
            echo PHP_EOL;
        }
    }
}

$program = new AsciiFigure();
$program->draw();
