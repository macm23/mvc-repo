<?php

namespace App\Game;

class CardGameGraphic extends CardGame
{
    /**
     * @var string[] Array of card representations
     */
    private $representations = [
        '🃑', '🃒', '🃓', '🃔', '🃕', '🃖', '🃗', '🃘', '🃙', '🃚', '🃛', '🃝', '🃞', // Spades
        '🃁', '🃂', '🃃', '🃄', '🃅', '🃆', '🃇', '🃈', '🃉', '🃊', '🃋', '🃍', '🃎', // Hearts
        '🂱', '🂲', '🂳', '🂴', '🂵', '🂶', '🂷', '🂸', '🂹', '🂺', '🂻', '🂽', '🂾', // Diamonds
        '🂡', '🂢', '🂣', '🂤', '🂥', '🂦', '🂧', '🂨', '🂩', '🂪', '🂫', '🂭', '🂮'  // Clubs
    ];

    /**
    * @var int[]
    */
    private $values = [
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, // Spades
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, // Hearts
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, // Diamonds
        1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13  // Clubs
    ];

    /**
        * @var CardGameCard
        */
    public $card;

    public function __construct()
    {
        parent::__construct();
    }


    public function shuffle(): int
    {
        $index = array_rand($this->representations);
        $this->card = new CardGameCard($this->representations[$index], $this->values[$index]);
        $this->value = $this->card->value; // Set the value in the parent class
        return $this->value; // Return the value as an integer
    }

    public function getAsString(): string
    {
        return (string) $this->card;
    }

    public function getValue(): int
    {
        return $this->value;
    }

}
