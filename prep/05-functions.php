<?php declare(strict_types=1);

echo "===== Exercise 1\n";
// Create a function that accepts any string and returns the same value with
// added "codelex" by the end of it. Print this value out.
function appendCodelex(string $input): string
{
    return $input . 'codelex';
}

echo appendCodelex('hello ') . "\n";

echo "\n===== Exercise 2\n";
// Create a function that accepts 2 integer arguments. First argument is
// a base value and the second one is a value its been multiplied by. For
// example, given argument 10 and 5 prints out 50
function multiplyTwo(int $x, int $y): int
{
    return $x * $y;
}

echo multiplyTwo(10, 5) . "\n";

echo "\n===== Exercise 3\n";
// Create a person object with name, surname and age. Create a function that
// will determine if the person has reached 18 years of age. Print out if the
// person has reached age of 18 or not.
class Person
{
    public string $name;
    public string $surname;
    public int $age;

    public function __construct(string $name, string $surname, int $age)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
    }
}

$person = new Person('John', 'Doe', 23);

function isAdult(Person $person): bool
{
    return $person->age >= 18;
}

if (isAdult($person)) {
    echo "{$person->name} {$person->surname} has reached the age of 18.\n";
} else {
    echo "{$person->name} {$person->surname} has not reached the age of 18.\n";
}

echo "\n===== Exercise 4\n";
// Create a array of objects that uses the function of exercise 3 but in loop
// printing out if the person has reached age of 18.
$people = [
    new Person('Jane', 'Doe', 21),
    new Person('Joe', 'Ordinary', 17),
    new Person('Richard', 'Roe', 29),
    new Person('Fnu', 'Lnu', 22)
];

foreach ($people as $person) {
    if (isAdult($person)) {
        echo "{$person->name} {$person->surname} has reached the age of 18.\n";
    } else {
        echo "{$person->name} {$person->surname} has not reached the age of 18.\n";
    }
}

echo "\n===== Exercise 5\n";
// Create a 2D associative array in 2nd dimension with fruits and their weight.
// Create a function that determines if fruit has weight over 10kg. Create
// a secondary array with shipping costs per weight. Meaning that you can say
// that over 10 kg shipping costs are 2 euros, otherwise its 1 euro. Using
// foreach loop print out the values of the fruits and how much it would cost
// to ship this product.
function getDeliveryCost(int $weight): int
{
    switch (true) {
        case ($weight > 10):
            return 2;
        default:
            return 1;
    }
}

$products = [
    'product1' => [
        'name' => 'apples',
        'weight' => 8
    ],
    'product2' => [
        'name' => 'oranges',
        'weight' => 15
    ],
    'product3' => [
        'name' => 'kiwi',
        'weight' => 3
    ]
];

$shippingCosts = [];

foreach ($products as $product) {
    $shippingCosts[$product['weight']] = getDeliveryCost($product['weight']);
}

foreach ($products as $key => $value) {
    echo "{$key}:\n name = {$value['name']}\n";
    echo " weight = {$value['weight']}kg\n";
    echo " shipping cost = {$shippingCosts[$value['weight']]}€\n";
}

echo "\n===== Exercise 6\n";
// Create an non-associative array with 5 elements where 3 are integers,
// 1 float and 1 string. Create a for loop that iterates non-associative array
// using php in-built function that determines count of elements in the array.
// Create a function that doubles the integer number. Within the loop using php
// in-built function print out the double of the number value (using your
// custom function).
function doubleInt(int $num): int
{
    return $num * 2;
}

$arr = [1, 2, 3, 3.14, 'π'];

for ($i = 0; $i < count($arr); $i++) {
    $num = $arr[$i];

    if (is_int($num)) {
        print(doubleInt($arr[$i]) . "\n");
    }
}

echo "\n===== Exercise 7\n";
// Imagine you own a gun store. Only certain guns can be purchased with
// license types. Create an object (person) that will be the requester to
// purchase a gun (object) Person object has a name, valid licenses (multiple)
// & cash. Guns are objects stored within an array. Each gun has license
// letter, price & name. Using PHP in-built functions determine if the
// requester (person) can buy a gun from the store.
class Client
{
    public string $name;
    public array $licenses;
    public float $cash;

    public function __construct(string $name, array $licenses, float $cash)
    {
        $this->name = $name;
        $this->licenses = $licenses;
        $this->cash = $cash;
    }
}

class Gun
{
    public string $name;
    public string $license;
    public float $price;

    public function __construct(string $name, string $license, float $price)
    {
        $this->name = $name;
        $this->license = $license;
        $this->price = $price;
    }
}

$person = new Client("John Doe", ['A', 'B', 'C'], 156);

$guns = [
    new Gun('pif', 'A', 89),
    new Gun('paf', 'E', 132),
    new Gun('puf', 'B', 210)
];

$available = array_filter($guns, function ($gun) use ($person) {
    if (in_array($gun->license, $person->licenses) and $person->cash >= $gun->price) {
        return true;
    }
    return false;
});

if (count($available) > 0) {
    echo "{$person->name} can buy a gun in the shop.\n";
} else {
    echo "{$person->name} can not buy a gun in the shop.\n";
}
