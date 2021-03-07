<?php

namespace Dog;

class DogTest
{
    public function main(): void
    {
        $max = new Dog(1, 'Max', Gender::MALE);
        $rocky = new Dog(2, 'Rocky', Gender::MALE);
        $sparky = new Dog(3, 'Sparky', Gender::MALE);
        $buster = new Dog(4, 'Buster', Gender::MALE);
        $sam = new Dog(5, 'Sam', Gender::MALE);
        $lady = new Dog(6, 'Lady', Gender::FEMALE);
        $molly = new Dog(7, 'Molly', Gender::FEMALE);
        $coco = new Dog(8, 'Coco', Gender::FEMALE);

        $max->setMother($lady);
        $max->setFather($rocky);

        $coco->setMother($molly);
        $coco->setFather($buster);

        $rocky->setMother($molly);
        $rocky->setFather($sam);

        $buster->setMother($lady);
        $buster->setFather($sparky);

        assert($coco->fathersName() === 'Buster', "Buster should be Coco's father.");
        assert($sparky->fathersName() === 'Unknown', "Sparky's father should be unknown.");

        assert($coco->hasSameMotherAs($rocky), "Coco should have the same mother as Rocky.");
        assert($max->hasSameMotherAs($buster), "Max should have the same mother as Buster.");
    }
}
