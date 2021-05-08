<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }
    
    /**
     * index
     * @Route("/biens", name="properties")
     * @return Response
     */
    public function index(): Response
    {

       
        //$property[0]->setSold(true);
        //$this->em->flush();
        
       return $this->render('property/index.html.twig', [
           'current_menu' => 'properties'
       ]) ;
    }
    
    /**
     * getProperty
     * @Route("/biens/{slug}-{id}", name="property.show", requirements = {"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show($slug, $id): Response {

        $property = $this->repository->find($id);

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
            'slug' => $slug
        ]);
    }
}