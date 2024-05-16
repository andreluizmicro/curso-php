<?php

declare(strict_types=1);

namespace Core\Model;

class User
{
    public function __construct(public string $name)
    {
    }

    public function getNome(): string
    {
        return $this->name;
    }
}
