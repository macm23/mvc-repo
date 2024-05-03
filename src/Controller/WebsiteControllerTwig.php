<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function year(): Response
    {

        $firstDate = "2000-05-03 20:00:00";
        $secondDate = "2024-05-03 20:00:00";

        $firstTime = strtotime($firstDate);
        $secondTime = strtotime($secondDate);

        $randomTime = rand($firstTime, $secondTime);

        $randomYear = date("Y-m-d H:i:s", $randomTime);

        $data = [
            'randomYear'   => $randomYear
        ];

        return $this->render('lucky.html.twig', $data);
    }


    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }


}
