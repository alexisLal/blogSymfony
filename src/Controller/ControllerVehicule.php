<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ControllerVehicule extends AbstractController
{
    #[Route('/new/vehicule', 'vehicule_create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        // $article->setTitre('Pokéball');
        // $article->setDescription('Capturez un Pokémon grâce à cette Pokéball !');
        //  $article->setContenu('x1 Pokéball Classique');
        //$vehicule->setDateCreation(new \DateTime('today'));



        $form = $this->createForm(VehiculeType::class);

        $prout = 'tom';

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $vehicule = new Vehicule();

            // $form->getData() holds the submitted values
            // but, the original `$article` variable has also been updated
            $vehicule = $form->getData();
            $vehicule->setAjoutePar($this->getUser());

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('listeVehicule');
        }

        //Affiche la page ajoutvehicule et ajoute un formulaire via un paramètre
        return $this->render('vehicule/formVehicule.html.twig', [
            'form_vehicule' => $form,
            'test' => $prout,
        ]);
    }

    #[Route('/vehicule/{id}', 'vehicule_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $vehicule = $entityManager->getRepository(Vehicule::class)->find($id);
        if (!$vehicule) {
            throw $this->createNotFoundException(
                'No vehicule found for id ' . $id
            );
        }
        return $this->render('vehicule/vehiculeUnique.html.twig', [
            'vehicule' => $vehicule,
        ]);
        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/liste-vehicule', 'listeVehicule')]
    public function listeDesVehicules(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Vehicule::class);
        $vehicules = $repository->findAll();
        return $this->render('vehicule/listeVehicule.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }

    #[Route('/vehicule/edit/{id}', 'vehicule_modif')]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $vehicule = $entityManager->getRepository(Vehicule::class)->find($id);

        if (!$vehicule) {
            throw $this->createNotFoundException(
                'No vehicule found for id ' . $id
            );
        }

        $form = $this->createForm(VehiculeType::class, $vehicule);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $form->getData() holds the submitted values
            // but, the original `$article` variable has also been updated
            $vehicule = $form->getData();


            // ... perform some action, such as saving the task to the database
            $entityManager->persist($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('listeVehicule');
        }

        return $this->render('vehicule/formVehicule.html.twig', [
            'form_vehicule' => $form,
        ]);
    }

    #[Route('/supprimer-vehicule/{id}', 'vehicule_suppr')]
    public function suppressionVehicule(EntityManagerInterface $entityManager, $id)
    {
        $vehicule = $entityManager->getRepository(Vehicule::class)->find($id);

        if ($this->getUser() ==  $vehicule->getAjoutePar()) {
            $entityManager->remove($vehicule);
            $entityManager->flush();

            return $this->redirectToRoute('listeVehicule');
        } else {
            throw new AccessDeniedException('Vous n\'avez pas la permission de supprimer ce véhicule');
        }
    }

    #[Route('/admin', 'admin')]
    public function admin()
    {
        return $this->redirectToRoute('listeVehicule');
    }
}
