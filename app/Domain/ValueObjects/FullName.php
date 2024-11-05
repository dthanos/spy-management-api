<?php

namespace App\Domain\ValueObjects;

final class FullName
{
    private string $name;
    private string $surname;

    public function __construct(string $name, string $surname)
    {
        $this->name = trim($name);
        $this->surname = trim($surname);
    }

    public function getFullName(): string
    {
        return "{$this->name} {$this->surname}";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function equals(FullName $other): bool
    {
        return $this->name === $other->name && $this->surname === $other->surname;
    }

    public function toString(): string
    {
        return $this->getFullName();
    }
}
