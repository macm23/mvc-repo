<?php

namespace App\Game;

class CardGame
{
    protected $value;

    public function __construct() // sätter värdet till noll varje gång man instanserar klassen
    {
        $this->value = null;
    }

    public function shuffle(): int
    {
        $this->value = random_int(1, 52);
        return $this->value;
    }


    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue($cardValue): void
    {
        $this->value = $cardValue;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }




}
