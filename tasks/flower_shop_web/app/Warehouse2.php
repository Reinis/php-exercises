<?php

namespace FlowerShopWeb;

use InvalidArgumentException;

class Warehouse2 extends Warehouse
{
    private const STORAGE_DIR = 'storage';

    public function __construct(string $name, string $csvFileName)
    {
        $flowers = $this->readFlowersFromCsvFile($csvFileName);

        parent::__construct($name, $flowers);
    }

    private function readFlowersFromCsvFile(string $csvFileName): Flowers
    {
        $filename = implode(DIRECTORY_SEPARATOR, [self::STORAGE_DIR, $csvFileName]);

        if (($handle = fopen($filename, 'rb')) === false) {
            throw new InvalidArgumentException("Could not open file for reading: {$csvFileName}");
        }

        $flowers = new Flowers();

        /** @var string[] $data */
        while (($data = fgetcsv($handle, 1000)) !== false && $data !== null) {
            if (isset($data[0], $data[1])) {
                $flowers->addFlower(new Flower($data[0], $data[1]));
            }
        }

        fclose($handle);

        return $flowers;
    }
}
