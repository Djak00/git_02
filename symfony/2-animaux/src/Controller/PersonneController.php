<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PersonneController extends AbstractController
{
    #[Route('/personnes', name: 'personnes')]
    public function personnes(PersonneRepository $repository): Response
    {
        $personnes=$repository->findAll();
        return $this->render('personne/personnes.html.twig', [
            "personnes"=>$personnes
        ]);
    }

    #[Route('/personne/{id}', name: 'afficher_personne')]
    public function personne(Personne $personne): Response
    {
   
        return $this->render('personne/afficherPersonne.html.twig', [
            "personne"=> $personne
        ]);
    }
}
