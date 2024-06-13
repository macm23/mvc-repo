<?php

namespace App\Controller;

use App\Game\CardGame;
use App\Game\CardGameDeck;
use App\Game\CardGameGraphic;
use App\Game\CardGameGraphicBack;
use App\Game\CardGameHand;
use App\Game\CardGameCard;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    #[Route("/game/session", name: "session_landing_page")]
    public function session(
        SessionInterface $session
    ): Response {

        $data = [
            'session' => $session->all()
        ];

        return $this->render('game/session.html.twig', $data);
    }

    #[Route("/game/session/delete", name: "session_delete_page")]
    public function sessionDelete(
        SessionInterface $session
    ): Response {

        $session->clear();

        $this->addFlash(
            'notice',
            'The session was deleted'
        );


        return $this->render('game/session_delete.html.twig');
    }


    #[Route("/game", name: "game_landing_page", methods: ['GET'])]
    public function cardGame(
        Request $request,
        SessionInterface $session
    ): Response {


        return $this->render('game.html.twig');
    }


  
    #[Route("/game/play", name: "play_cardgame_get", methods: ['GET'])]
    public function playCardGamePost(        SessionInterface $session
    ): Response {

        
        $cardBackValues = range(1, 1);

        $cardDeck = [];

        foreach ($cardBackValues as $cardValue) {
            $card = new CardGameGraphicBack();

            $card->setValue($cardValue);

            $cardRepresentation = $card->getAsString();

            $cardDeck[] = $cardRepresentation;
        }



        $data = [
            "cardDeckBack" => $cardDeck      
        ];

      return $this->render('game/play_cardgame.html.twig', $data);
    }



    #[Route("/game/play", name: "play_cardgame_post", methods: ['POST'])]
    public function playCardGame(
        SessionInterface $session
    ): Response {


    $hand = new CardGameHand();
    for ($i = 1; $i <= 1; $i++) {
        $hand->add(new CardGameGraphic());
    }

     $hand->shuffle();
    
        $session->set("cardgame_hand", $hand);
        $session->set("cardgame_card", 0);
        $session->set("cardgame_round", 0);
        $session->set("cardgame_total", 0);        


          return $this->redirectToRoute('play_cardgame_3');

    }


    #[Route("/game/playgame", name: "play_cardgame_3", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response {


        
        $cardValues = range(1, 1);

        $cardDeckBack = [];

        foreach ($cardValues as $cardValue) {
            $card = new CardGameGraphicBack(); 

            $card->setValue($cardValue);

            $cardRepresentation = $card->getAsString();

            $cardDeckBack[] = $cardRepresentation;
        }



        $cardgame_hand = $session->get("cardgame_hand");

        $data = [
            "cardDeckBack" => $cardDeckBack,
            "result" => $session->get("cardgame_card"),
            "round" => $session->get("cardgame_round"),
            "total" => $session->get("cardgame_total"),
            "cardValues" => $cardgame_hand->getString()
        ];

        return $this->render('game/play_cardgame_play.html.twig', $data);
    }

    
   
    #[Route("/game/drawcard", name: "draw_card", methods: ['POST'])]
    public function drawcard(
        SessionInterface $session
    ): Response {
       

    $hand = $session->get("cardgame_hand");
    $hand->shuffle();


    $roundTotal = $session->get("cardgame_round");
    $round = 0;

    $values = $hand->getValues();
    foreach ($values as $value) {   

         $round += $value;

         $totalPoints = $roundTotal + $round; 

       if ($totalPoints > 21)  {
         
            $this->addFlash(
                'Warning!',
                'You lost'
            );

            break;
          }
          else if ($totalPoints === 21)
          {
          $this->addFlash(
            'Warning!',
            'You won!'
        );

        break;
        }

    }
 
    $cardgame_hand = $session->get("cardgame_hand");

    $session->set("cardgame_round", $roundTotal + $round);
    $session->set("cardgame_total", $round);



    return $this->redirectToRoute('play_cardgame_3');
    }

    #[Route("/game/playbank", name: "play_cardgame_bank_get", methods: ['GET'])]
    public function playCardBank(): Response {

        
        $cardBackValues = range(1, 1);

        $cardDeck = [];

        foreach ($cardBackValues as $cardValue) {
            $card = new CardGameGraphicBack();

            $card->setValue($cardValue);

            $cardRepresentation = $card->getAsString();

            $cardDeck[] = $cardRepresentation;
        }

        $data = [
            "cardDeckBack" => $cardDeck
       ];


      return $this->render('game/play_cardgame_bank.html.twig', $data);
 

    }

    

    #[Route("/game/playbank", name: "play_cardgame_bank_post", methods: ['POST'])]
    public function playCardGameBank2(
        Request $request,
        SessionInterface $session
    ): Response {

    

        $takenCard = $request->request->get('one_card_bank');
    
        $hand = new CardGameHand();
        for ($i = 1; $i <= 1; $i++) {
            $hand->add(new CardGameGraphic());
        }
    
        $hand->shuffle();
    
        $session->set("cardgame_hand_bank", $hand);
        $session->set("cardgame_card_bank", 0);
        $session->set("cardgame_round_bank", 0);
        $session->set("cardgame_total_bank", 0);
        

          return $this->redirectToRoute('playcardgame_bank');

    }

    

    #[Route("/game/playbank", name: "playcardgame_bank", methods: ['GET'])]
    public function playCardGameBank(
        SessionInterface $session
    ): Response {


        
        $cardValues = range(1, 1);

        $cardDeckBack = [];

        foreach ($cardValues as $cardValue) {
            $card = new CardGameGraphicBack(); 

            $card->setValue($cardValue);

            $cardRepresentation = $card->getAsString();

            $cardDeckBack[] = $cardRepresentation;
        }

        $cardgame_hand_bank = $session->get("cardgame_hand_bank");

        $data = [

            "cardDeckBack" => $cardDeckBack,
            "resultBank" => $session->get("cardgame_card_bank"),
            "roundBank" => $session->get("cardgame_round_bank"),
            "totalBank" => $session->get("cardgame_total_bank"),
            "playerHand" => $session->get("cardgame_total"),
            "cardValuesBank" => $cardgame_hand_bank->getString()
        ];

        return $this->render('game/play_cardgame_play_bank.html.twig', $data);

    }


       
    #[Route("/game/drawcardbank", name: "draw_card_bank", methods: ['POST'])]
    public function drawcardBank(
        SessionInterface $session
    ): Response {


 
    $cardgame_hand = $session->get("cardgame_hand");

    $session->set("card_left", $cardsLeft);
    $session->set("cardgame_round_bank", $roundTotal + $round);
    $session->set("cardgame_total_bank", $round);
    $session->set("cardValuesBank", $cardgame_hand->getString());

    return $this->redirectToRoute('playcardgame_bank');

    $hand = $session->get("cardgame_hand_bank");
    $hand->shuffle();

    
    $roundTotal = $session->get("cardgame_round_bank");
    $round = 0;
    $totalValue = $session->get("cardgame_total_bank", 0);
    $playerHand = $session->get("cardgame_total");


    while ($roundTotal < 17) {
        $hand->shuffle();
        $values = $hand->getValues();

        foreach ($values as $value) {
            $roundTotal += $value;

            if ($roundTotal >= 17) {
                break;
            }
        }
    }

    if ($roundTotal > 21) {
        $this->addFlash(
            'Warning!',
            'The bank lost, you won!'
        );
    } else if ($roundTotal == 21) {
        $this->addFlash(
            'Warning!',
            'The bank won!'
        );
    } else if ($roundTotal >= $playerHand) {
        $this->addFlash(
            'Warning!',
            'The bank won!'
        );
    }

    $session->set("card_left_bank", $cardsLeft);
    $session->set("cardgame_total_bank", $totalValue);
    $session->set("cardgame_round_bank", $roundTotal);
    $session->set("cardValuesBank", $hand->getString());

    return $this->redirectToRoute('playcardgame_bank');

    }

    

      
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response {


        return $this->render('game/doc_cardgame.html.twig');
    }

}
