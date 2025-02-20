<?php

namespace App\Controller;

use App\Entity\Arme;
use App\Entity\Personnage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonnageController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('personnage/index.html.twig');
    }

    #[Route('/persos', name: 'personnages')]
    public function persos(): Response
    {
        Personnage::creerPersonnage();
    
        return $this->render('personnage/persos.html.twig', [
            "players"=> Personnage::$personnages

        ]);
    }

    #[Route('/persos/{nom}', name: 'affich_personnage')]
    public function affichPerso($nom): Response
    {
        Personnage::creerPersonnage();
        $perso = Personnage::getPersonnageParNom($nom);
        return $this->render('personnage/perso.html.twig', [
            "perso"=> $perso

        ]);
    }

    
}
