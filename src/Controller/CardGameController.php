<?php

namespace App\Controller;


use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{    
    #[Route("/session", name: "session_landing_page")]
    public function session(        
        SessionInterface $session
    ): Response
    {

        $data = [
            'session' => $session->all()    
        ];

        return $this->render('card/session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete_page")]
    public function sessionDelete(        
        SessionInterface $session
    ): Response
    {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session was deleted'
        );


        return $this->render('card/session_delete.html.twig');
    }



    #[Route("/card", name: "card")]
    public function home(): Response
    {
        return $this->render('card.html.twig');
    }


    #[Route("/card/deck", name: "show_cards")]
    public function cardDeck(SessionInterface $session
    ): Response
    {

$cardValues = range(1, 13);
$cardValues2 = range(14, 26);
$cardValues3 = range(27, 39);
$cardValues4 = range(40, 52);


    
$cardRoll1 = [];

foreach ($cardValues as $cardValue) {
    $card = new CardGraphic();
    
    $card->setValue($cardValue);
    
    $cardRepresentation = $card->getAsString();
    
    $cardRoll1[] = $cardRepresentation;
}

$cardRoll2 = [];
foreach ($cardValues2 as $cardValue) {
    $card = new CardGraphic(); 
    
    $card->setValue($cardValue);
    
    $cardRepresentation = $card->getAsString();
    
    $cardRoll2[] = $cardRepresentation;
}

$cardRoll3 = [];
foreach ($cardValues3 as $cardValue) {
    $card = new CardGraphic(); 
    
    $card->setValue($cardValue);

    $cardRepresentation = $card->getAsString();
    
    $cardRoll3[] = $cardRepresentation;
}

$cardRoll4 = [];
foreach ($cardValues4 as $cardValue) {
    $card = new CardGraphic(); 

    $card->setValue($cardValue);
    
    $cardRepresentation = $card->getAsString();
    
    $cardRoll4[] = $cardRepresentation;
}


$data = [
    "num_cards" => count($cardRoll1),
    "cardRoll1" => $cardRoll1,
    "cardRoll2" => $cardRoll2,
    "cardRoll3" => $cardRoll3, 
    "cardRoll4" => $cardRoll4
];
        $session->set("cardRoll1", ($cardRoll1));
          
        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle_cards")]
    public function cardDeckShuffle(
        SessionInterface $session
    ): Response
    {
        $session->clear(); 

        $cardValues = range(1, 52);
    
$cardRoll1 = [];

foreach ($cardValues as $cardValue) {
    $card = new CardGraphic(); 
    
    $card->shuffle();
    
    $cardRepresentation = $card->getAsString();
    
    $cardRoll1[] = $cardRepresentation;
}

        $data = [
            "num_cards" => count($cardRoll1),
            "cardRoll" => $cardRoll1
        ];

        $session->set("cardRoll", $cardRoll1);

        return $this->render('card/deck_shuffle.html.twig', $data);
    }

#[Route("/card/deck/draw", name: "draw_cards_get_one", methods: "GET")]
    public function cardDeckDrawOne(SessionInterface $session): Response
    {

        $cardRoll = [];
        
        for ($i = 1; $i <= 1; $i++) {
            $cards = new CardGraphic();
            $cards->shuffle();
            $cardRoll[] = $cards->getAsString();            
        }         

        $cardsLeft = $session->get('card_left', 52);

        $numToDraw = min(1, $cardsLeft);

        $cardsLeft -= $numToDraw;

        if ($cardsLeft < 1) {
            throw new \Exception("Not enough cards left to draw!");
        }

     
        if (0 > $cardsLeft) {
            throw new \Exception("Not enough cards left!");
        }


        $session->set("num_of_cards", 1); 
        $session->set("card_deck", $cardRoll);
        $session->set("card_left", $cardsLeft);

        $data = [
            "num_cards" => 1,
            "cardRoll" => $cardRoll,
            "cards_left" => $cardsLeft
        ];

 
        return $this->render('card/draw_cards.html.twig', $data);
    }


   #[Route("/card/deck/draw/{num<\d+>}", name: "draw_cards_get", methods: "GET")]
    public function cardDeckDraw(int $num, SessionInterface $session): Response
    {

        if ($num > 52) {
            throw new \Exception("Can not draw more than 52 cards!");
        }

        
        $cardRoll = [];
        
        for ($i = 1; $i <= $num; $i++) {
            $cards = new CardGraphic();
            $cards->shuffle();
            $cardRoll[] = $cards->getAsString();            
        }         

        $cardsLeft = $session->get('card_left', 52);

        $numToDraw = min($num, $cardsLeft);

        $cardsLeft -= $numToDraw;

        if ($cardsLeft < $num) {
            throw new \Exception("Not enough cards left to draw!");
        }


        $session->set("num_of_cards", $num); 
        $session->set("card_deck", $cardRoll);
        $session->set("card_left", $cardsLeft);

        $data = [
            "num_cards" => $num,
            "cardRoll" => $cardRoll,
            "cards_left" => $cardsLeft
        ];
        

        return $this->render('card/draw_cards.html.twig', $data);
    }
    

}