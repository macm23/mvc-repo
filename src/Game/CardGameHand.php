<?php

namespace App\Game;

use App\Card\Game;

class CardGameHand
{
    private $deck = [];

    public function add(CardGame $card): void
    {
        $this->deck[] = $card;
    }

    public function shuffle(): void
    {
        foreach ($this->deck as $card) {

            $card->shuffle();
        }
    }

    /*public function deck(): void
    {
        foreach ($this->deck as $card) {

            $card->cardDeck();
        }
    }
*/

    public function getCardsNumber(): int
    {
        return count($this->deck);
    }

    public function getCardsValue(): int
    {
        $handValue = 0;
        foreach ($this->deck as $card) {
            $handValue += $card->getValue();
        }
        return $handValue;
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

    public function getTotalValue(): int {
        $total = 0;
        foreach ($this->deck as $card) {
            $total += $card->getValue();
        }
        return $total;
    }

   
}
