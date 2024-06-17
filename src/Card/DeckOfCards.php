<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{

     /**
 * @var Card[]
 */
    private array $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function shuffle(): void
    {
        foreach ($this->deck as $card) {

            $card->shuffle();
        }


    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

        /**
     * @return int[]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

        /**
     * @return string[]
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
