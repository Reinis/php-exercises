<?php

namespace VideoStore;

class VideoStoreTest
{
    public function main(): void
    {
        $store = new VideoStore();
        $store->addVideo("The Matrix");
        $store->addVideo("Godfather II");
        $store->addVideo("Star Wars Episode IV: A New Hope");

        for ($i = 0; $i < 5; $i++) {
            foreach ($store->getTitles() as $title) {
                /** @noinspection RandomApiMigrationInspection */
                $store->rateVideo($title, rand(1, 5));
            }
        }

        foreach ($store->getTitles() as $title) {
            $store->checkOutVideo($title);
            $store->returnVideo($title);
        }

        $store->checkOutVideo("Godfather II");
        echo $store->listVideos() . PHP_EOL;
    }
}
