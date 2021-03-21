<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use CarRental\Services\CarDataService;
use CarRental\View;


$dataService = new CarDataService();
$cars = $dataService->deserializeCars();

$view = new View();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

if ($uri === '/' && $httpMethod === 'POST') {
    $action = $_POST['action'] ?? 'none';
    $id = $_POST['carId'] ?? 'none';

    if ($action === 'none' || $id === 'none') {
        $view->error();
    }

    try {
        $cars->getById($id)->changeStatus($action);
    } catch (InvalidArgumentException $e) {
        $view->error();
    }

    $dataService->serializeCars($cars);
    header("Location: /");
    die();
}

$view->home($cars);
