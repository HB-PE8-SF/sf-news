<?php

namespace App\Data;

class Student
{
    public function __construct(
        private string $name,
        private int $number
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
