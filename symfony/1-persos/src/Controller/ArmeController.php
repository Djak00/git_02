<?php

namespace App\Controller;

use App\Entity\Arme;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ArmeController extends AbstractController
{
    #[Route('/armes', name: 'armes')]
    public function armes(): Response
    {
        Arme::creerArme();
    
        return $this->render('arme/armes.html.twig', [
            "armes"=> Arme::$tabArmes

        ]);
    }

    #[Route('/arme/{nom}', name: 'affich_arme')]
    public function arme($nom): Response
    {
        Arme::creerArme();
        $arme = Arme::getArmeParNom($nom);

        return $this->render('arme/arme.html.twig', [
            "arme"=> $arme

        ]);
    }
}
