<?php

namespace FlowerShopWeb;

use InvalidArgumentException;
use JsonException;

class Warehouse3 extends Warehouse
{
    public function __construct(string $name, string $jsonFileName)
    {
        $flowers = $this->readFlowersFromJsonFile($jsonFileName);

        parent::__construct($name, $flowers);
    }

    private function readFlowersFromJsonFile(string $jsonFileName): Flowers
    {
        $filename = 'storage/' . $jsonFileName;

        if (($handle = fopen($filename, 'rb')) === false) {
            throw new InvalidArgumentException("Could not open file for reading: {$jsonFileName}");
        }

        $json = fread($handle, filesize($filename));
        $flowers = new Flowers();
        $data = null;

        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }

        if ($data !== false && $data !== null) {
            foreach ($data as ['name' => $name, 'amount' => $amount]) {
                $flowers->addFlower(new Flower($name, $amount));
            }
        }

        fclose($handle);

        return $flowers;
    }
}
