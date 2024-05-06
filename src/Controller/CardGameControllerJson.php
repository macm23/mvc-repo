<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJson
{
    #[Route("/api/deck", name: "deck_json", methods: ["GET"])]
    public function jsonDeck(Request $request): Response
    {

        $cardValues = range(1, 52);

        $cardRoll1 = [];

        // Generate card representations based on the sorted card values
        foreach ($cardValues as $cardValue) {
            $card = new CardGraphic(); // Create a new CardGraphic instance

            // Set the card value directly (without shuffling)
            $card->setValue($cardValue);

            // Get the emoji representation for the card value
            $cardRepresentation = $card->getAsString();

            // Add the card representation to the cardRoll1 array
            $cardRoll1[] = $cardRepresentation;
        }

        // Prepare data to pass to the template
        $data = [
            "num_cards" => count($cardRoll1),
            "cardRoll1" => $cardRoll1
        ];



        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }


    #[Route("/api/deck/shuffle", name: "shuffle_cards_json", methods:["POST"])]
    public function jsonDeckShufflePost(
        Request $request,
        SessionInterface $session
    ): Response {
        $cardRoll = [];
        for ($i = 1; $i <= 52; $i++) {
            $cards = new CardGraphic();
            $cards->shuffle();
            $cardRoll[] = $cards->getAsString();
        }

        $data = [
            "number_of_cards" => count($cardRoll),
            "cards" => $cardRoll
        ];


        $session->set("number_of_cards", count($cardRoll));
        $session->set("cards", $cardRoll);

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }



    #[Route("/api/deck/draw", name: "draw_cards_json", methods: ["POST"])]
    public function jsonDeckDraw(
        Request $request,
        SessionInterface $session
    ): Response {
        $cardRoll = [];

        for ($i = 1; $i <= 1; $i++) {
            $cards = new CardGraphic();
            $cards->shuffle();
            $cardRoll[] = $cards->getAsString();
        }

        $cardsLeft = $session->get('card_left', 52);

        $numToDraw = min(1, $cardsLeft);

        $cardsLeft -= $numToDraw;


        if (0 > $cardsLeft) {
            throw new \Exception("Not enough cards left!");
        }


        $session->set("num_of_cards", 1);
        $session->set("card_deck", $cardRoll);
        $session->set("card_left", $cardsLeft);

        $data = [
            "num_cards" => 1,
            "card_deck" => $cardRoll,
            "card_total" => $cardsLeft
        ];


        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }


    #[Route("/api/deck/draw", name: "draw_multiple_cards_json", methods: ["POST"])]
    public function jsonDeckDrawMultiple(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCards = $request->request->get('num_cards');

        $cardRoll = [];

        for ($i = 1; $i <= $numCards; $i++) {
            $cards = new CardGraphic();
            $cards->shuffle();
            $cardRoll[] = $cards->getAsString();
        }

        $cardsLeft = $session->get('card_left', 52);

        $numToDraw = min($numCards, $cardsLeft);

        $cardsLeft -= $numToDraw;

        if ($cardsLeft < $numCards) {
            throw new \Exception("Not enough cards left to draw!");
        }


        $session->set("num_of_cards", $numCards);
        $session->set("card_deck", $cardRoll);
        $session->set("card_left", $cardsLeft);

        $data = [
            "num_cards" => $numCards,
            "card_deck" => $cardRoll,
            "cards_left" => $cardsLeft
        ];
        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "draw_get_cards", methods: ['GET'])]
    public function drawJsonGet(
        Request $request,
        SessionInterface $session,
        $num
    ): Response {

        $num = $request->attributes->get('num');

        $cardRoll = [];

        for ($i = 1; $i <= $num; $i++) {
            $cards = new CardGraphic();
            $cards->shuffle();
            $cardRoll[] = $cards->getAsString();
        }


        $cardsLeft = $session->get('card_left', 52);

        $numToDraw = min($num, $cardsLeft);

        $cardsLeft -= $numToDraw;

        $data = [
            "num_of_cards" => $num,
            "card_deck" => $cardRoll,
            "cards_left" => $cardsLeft
        ];

        $session->set("num_of_cards", $num);
        $session->set("card_deck", $cardRoll);
        $session->set("card_left", $cardsLeft);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
