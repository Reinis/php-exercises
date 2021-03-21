<?php

namespace CarRental\Services;

use CarRental\Entities\Car;
use CarRental\Entities\Collections\Cars;
use InvalidArgumentException;
use JsonException;
use RuntimeException;

class CarDataService
{
    private const STORAGE_DIR = 'storage';
    private string $fileName = 'cars.json';

    public function __construct()
    {
        $this->fileName = implode(DIRECTORY_SEPARATOR, [self::STORAGE_DIR, $this->fileName]);
    }

    public function deserializeCars(): Cars
    {
        $contents = file_get_contents($this->fileName);

        if ($contents === false) {
            throw new RuntimeException("Failed to read JSON file}");
        }

        $data = json_decode($contents, false, 512, JSON_THROW_ON_ERROR);

        $cars = new Cars();

        foreach ($data as $item) {
            $cars->addCar(
                new Car(
                    $item->id,
                    $item->name,
                    $item->model,
                    $item->fuelEconomy,
                    $item->price,
                    $item->status,
                )
            );
        }

        return $cars;
    }

    public function serializeCars(Cars $cars): void
    {
        if (($handle = fopen($this->fileName, 'wb')) === false) {
            throw new InvalidArgumentException("Could not open file for reading: {$this->fileName}");
        }

        try {
            fwrite($handle, json_encode($cars, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
        } catch (JsonException $e) {
            throw new JsonException($e->getMessage(), (int)$e->getCode());
        } finally {
            fclose($handle);
        }
    }
}
