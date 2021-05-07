<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;


class HomeController extends AbstractController
{

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }
    
    /**
     * index
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/home.html.twig');
    }

}