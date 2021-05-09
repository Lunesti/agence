<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController 
{
    
    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em) {
        $this->repository = $repository;
        $this->em = $em;
    }
         
    /**
     * index
     * @Route("/admin", name="admin.property.index")
     * @return void
     */
    public function index() {
        $properties = $this->repository->findAll();
        return $this->render("admin/property/index.html.twig", compact('properties'));
    }

        
    /**
     * edit
     * @Route("/admin/{id}", name="admin.property.edit")
     * @param  mixed $property
     * @return void
     */
    public function edit(Property $property, Request $request) {
       $form = $this->createForm(PropertyType::class, $property);

       
        return $this->render("admin/property/edit.html.twig", [
            'form' => $form->createView(),
            'property' => $property,
        ]);
    }
}