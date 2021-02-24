<?php

do {
    $base = filter_var(readline("-> Integer: "), FILTER_VALIDATE_INT);
} while ($base === false);

do {
    $power = filter_var(readline("-> Number of terms: "), FILTER_VALIDATE_INT);
} while ($power === false);

//todo complete loop to multiply i with itself n times, it is NOT allowed to use built-in pow() function
$product = 1;

for ($i = 0; $i < $power; $i++) {
    $product *= $base;
}

echo "Product = {$base}^{$power} = {$product}\n";
