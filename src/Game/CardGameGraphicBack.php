<?php

namespace App\Game;

class CardGameGraphicBack extends CardGame
{
    //
      /**
     * @var string[] Array of card representation
     */
    private $representation = [
        '🂠'
    ];

    public function __construct()
    {
        parent::__construct();
    }



    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }


}
