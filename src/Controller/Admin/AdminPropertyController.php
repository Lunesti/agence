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
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController
{

    private $repository;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * index
     * @Route("/admin", name="admin.property.index")
     * @return void
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render("admin/property/index.html.twig", compact('properties'));
    }

    /**
     * new
     * @Route("/admin/property/create", name="admin.property.new")
     * @return void
     */
    public function new(Request $request)
    {
        //Vu q'uon a pas d'infos qui provient de la bdd on crée un bien vide
        $property = new Property();

        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien créé avec succès');


            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render("admin/property/new.html.twig", [
            'form' => $form->createView(),
            'property' => $property,
        ]);
    }


    //Quand on met à jour un objet, nous ne passons pas par l'entityManager. la méthode persiste signale à Doctrine q'un objet doit être enregistré dans la BDD. pour une mise à jour (un edit), nous n'avons pas besoin de le signaler à doctrine,
    //donc on flush directement. on flush lorsqu'on veut mettre à jour un champs qui a été signalé au préalable par doctine dans la base. lorsqu'on a ajouté cet objet, on l'a signalé à docrtine, si on veut l'éditer, on flush directement car
    //l'objet est déja en base. Lorsqu'on veut ajouté de nouvelles données, nous devons persister, pour indiquer à doctrine des nouvelles données entrantes.


    /**
     * edit
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param  mixed $property
     * @return void
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render("admin/property/edit.html.twig", [
            'form' => $form->createView(),
            'property' => $property,
        ]);
    }

    //On va spécifier la même route pour la méthode edit et delete, mais en indiquant à la méthode delete qu'elle doit accepter que les requêtes
    //qui viennent avec une méthode de type delete.
    //Dans la méthode edit on va indiquer qu'on accepte que les méthodes get ou post (methods="GET|POST").Comme ça, dans cette méthode, on n'acceptera pas
    //une méthode qui vient de delete.
    //Comme ça on peut avoir, suivant la méthode qui est utilisé par le navigateur le chemin GET|POST qui est appelé OU le chemin DELETE.
    //Afin que ça fonctionne il faut créer un mini formulaire pour pointer vers la méthode DELETE. On ne peut pas mettre un lien avec une méthode
    //comme ça, ça ne va pas fonctionner sinon.
    
    /**
     * delete
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param  mixed $property
     * @return void
     */
    public function delete(Property $property, Request $request): Response {
        $submittedToken = $request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $submittedToken)) {
       $this->em->remove($property);
        //On va porter les informations au niveau de la BDD avec flush()
        $this->em->flush();
        $this->addFlash('success', 'Bien supprimé avec succès');

        }

        return $this->redirectToRoute('admin.property.index');
    }
}
