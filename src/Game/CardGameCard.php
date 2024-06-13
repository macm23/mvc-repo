<?php

namespace App\Game;


class CardGameCard
{
    public string $representation;
    public int $value;

    public function __construct(string $representation, int $value)
    {
        $this->representation = $representation;
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->representation;
    }
}
