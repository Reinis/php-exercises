<?php

namespace VideoStore;

class Application
{
    private VideoStore $store;

    public function __construct()
    {
        $this->store = new VideoStore();
    }

    public function run(): void
    {
        while (true) {
            echo "Choose the operation you want to perform \n";
            echo "Choose 0 for EXIT\n";
            echo "Choose 1 to fill video store\n";
            echo "Choose 2 to rent video (as user)\n";
            echo "Choose 3 to return video (as user)\n";
            echo "Choose 4 to list inventory\n";

            $command = (int)readline();

            switch ($command) {
                case 0:
                    echo "Bye!\n";
                    die;
                case 1:
                    $this->addMovies();
                    break;
                case 2:
                    $this->rentVideo();
                    break;
                case 3:
                    $this->returnVideo();
                    break;
                case 4:
                    $this->listInventory();
                    break;
                default:
                    echo "Sorry, I don't understand you..";
            }
        }
    }

    private function addMovies(): void
    {
        while (true) {
            $input = readline('-> Video title (q - exit): ');

            if ($input === 'q') {
                break;
            }

            if (strlen($input) < 2) {
                echo "Title too short!\n";
                continue;
            }

            $this->store->addVideo($input);
        }
    }

    private function rentVideo(): void
    {
        $titles = $this->store->getTitles();

        foreach ($titles as $index => $title) {
            echo $index . '. ' . $title . PHP_EOL;
        }

        while (true) {
            $input = readline('-> Select video to rent (q - exit): ');

            if ($input === 'q') {
                return;
            }

            $index = filter_var($input, FILTER_VALIDATE_INT);

            if ($index === false || !isset($titles[$index])) {
                echo "Invalid index!\n";
                continue;
            }

            try {
                $this->store->checkOutVideo($titles[$index]);
            } catch (\InvalidArgumentException $exception) {
                echo $exception->getMessage() . PHP_EOL;
                continue;
            }
        }
    }

    private function listInventory(): void
    {
        echo $this->store->listVideos() . PHP_EOL;
    }

    private function returnVideo(): void
    {
        $titles = $this->store->getTitles();

        foreach ($titles as $index => $title) {
            echo $index . '. ' . $title . PHP_EOL;
        }

        while (true) {
            $input = readline('-> Select video to return (q - exit): ');

            if ($input === 'q') {
                return;
            }

            $index = filter_var($input, FILTER_VALIDATE_INT);

            if ($index === false || !isset($titles[$index])) {
                echo "Invalid index!\n";
                continue;
            }

            try {
                $this->store->returnVideo($titles[$index]);
            } catch (\InvalidArgumentException $exception) {
                echo $exception->getMessage() . PHP_EOL;
                continue;
            }
        }
    }
}
