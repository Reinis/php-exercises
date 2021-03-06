<?php

$animals = ['sheep', 'sheep', 'sheep', 'wolf', 'sheep', 'wolf', 'sheep', 'sheep'];

// Expected output: Happy, Happy, OMG, HEHE, OMG, HEHE, OMG, Happy

$size = count($animals);

for ($i = 0; $i < $size; $i++) {
    $neighbours = [];

    if ($i !== 0) {
        $neighbours[] = $animals[$i - 1];
    }
    if ($i !== $size - 1) {
        $neighbours[] = $animals[$i + 1];
    }

    switch ($animals[$i]) {
        case 'sheep':
            if (in_array('wolf', $neighbours)) {
                echo 'OMG';
            } else {
                echo 'Happy';
            }
            break;
        case 'wolf':
            if (in_array('sheep', $neighbours)) {
                echo 'HEHE';
            }
            break;
    }

    if ($i !== $size - 1) {
        echo ', ';
    } else {
        echo PHP_EOL;
    }
}
