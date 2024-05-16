<?php

declare(strict_types=1);

namespace Core\Model;

class Lance
{
    public function __construct(
        public User $user,
        public float $value
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
