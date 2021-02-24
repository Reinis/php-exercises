<?php

do {
    $number = filter_var(readline("Input number of terms: "), FILTER_VALIDATE_INT);
} while ($number === false);

//todo complete loop to multiply i with itself n times, it is NOT allowed to use built-in pow() function
$product = 1;

for ($i = 0; $i < $number; $i++) {
    $product *= $number;
}

echo "Product = {$number}^{$number} = {$product}\n";
