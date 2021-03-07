<?php

namespace Dog;

use InvalidArgumentException;
use LogicException;

class Dog
{
    private int $id;
    private string $name;
    private string $gender;
    private ?Dog $mother = null;
    private ?Dog $father = null;

    public function __construct(int $id, string $name, string $gender)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Id should be larger than zero.");
        }

        $this->name = $name;
        $this->gender = $gender;
        $this->id = $id;
    }

    public function setFather(Dog $father): void
    {
        if ($father->getGender() !== Gender::MALE) {
            throw new LogicException("Father should be male.");
        }

        $this->father = $father;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function fathersName(): string
    {
        return $this->father === null ? 'Unknown' : $this->father->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function hasSameMotherAs(Dog $dog): bool
    {
        if ($this->getMother() === null || $dog->getMother() === null) {
            return false;
        }

        return $this->getMother()->getId() === $dog->getMother()->getId();
    }

    public function getMother(): ?Dog
    {
        return $this->mother;
    }

    public function setMother(Dog $mother): void
    {
        if ($mother->getGender() !== Gender::FEMALE) {
            throw new LogicException("Mother should be female.");
        }

        $this->mother = $mother;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
