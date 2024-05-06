<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{
    private $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function shuffle(): void
    {
        foreach ($this->deck as $card) {

            $card->shuffle();
        }

        /* foreach ($this->deck as $card) {
             $card->shuffle();
         }*/
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
