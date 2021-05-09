<?php
namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController 
{
    

    public function __construct(PropertyRepository $repository) {
        $this->repository = $repository;
    }
         
    /**
     * index
     * @Route('/admin/admin.property.index)
     * @return void
     */
    public function index() {
        $properties = $this->repository->findAll();
        return $this->render("admin/property/index.html.twig", compact('properties'));
    }

    public function edit(PropertyRepository $property) {
        $properties = $this->repository->find($id);
        return $this->render("admin/property/index.html.twig", compact('properties'));
    }
}