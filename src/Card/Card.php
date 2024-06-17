<?php

namespace App\Card;

class Card
{
    /**
    * @var int
    */
    protected $value;

    public function __construct() // sätter värdet till noll varje gång man instanserar klassen
    {
        $this->value = 0;
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

    /**
 * @param int $cardValue
 */
    public function setValue($cardValue): void
    {
        $this->value = $cardValue;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }




}
