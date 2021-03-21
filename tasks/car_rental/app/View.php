<?php

namespace CarRental;

use CarRental\Entities\Collections\Cars;

class View
{
    public function error(): void
    {
        require_once __DIR__ . '/Views/error.html';
        die();
    }

    public function home(Cars $cars): void
    {
        require_once __DIR__ . '/Views/home.php';
        die();
    }
}
