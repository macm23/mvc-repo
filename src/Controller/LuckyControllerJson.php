<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api")]
    public function jsonNumber(): Response
    {

        $data = [
            'lucky-message' => 'Routes'
        ];

       // return new JsonResponse($data);

       $response = new JsonResponse($data);
       $response->setEncodingOptions(
           $response->getEncodingOptions() | JSON_PRETTY_PRINT
       );
       return $response;
    }


    
    #[Route("/api/quote")]
    public function jsonQuote(): Response
    {
        $quotes = array(
            "I'm not superstitious, but I am a little stitious - Michael Scott",
            "And I knew exactly what to do. But in a much more real sense, I had no idea what to do. - Michael Scott",
            "Sometimes I'll start a sentence and I don't even know where it's going. I just hope I find it along the way. - Michael Scott"
        );

        

        $randomQuote = $quotes[array_rand($quotes)];

        date_default_timezone_set('Europe/Stockholm');	
        
        $date = date('Y-m-d H:i:s'); 

    

        $data = [
            'Quote of the day' => $randomQuote,
            'Date' => $date
        ];

       // return new JsonResponse($data);

       $response = new JsonResponse($data); 
       $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
       $response->setEncodingOptions(
           $response->getEncodingOptions() | JSON_PRETTY_PRINT
       );
       return $response;
    }
}
