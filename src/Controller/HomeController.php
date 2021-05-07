<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class HomeController
{

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }
    
    /**
     * index
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(): Response{
        return new Response($this->twig->render('pages/home.html.twig'));
    }

}