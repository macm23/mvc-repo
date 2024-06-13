<?php

namespace App\Game;

class CardGameGraphicBack extends CardGame
{
    //
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

