<?php

namespace App\Controller;

use App\Entity\Continent;
use App\Repository\ContinentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContinentController extends AbstractController
{
    #[Route('/continents', name: 'continents')]
    public function continents(ContinentRepository $repository ): Response
    {
        $continents = $repository->findAll();
        return $this->render('continent/continents.html.twig', [
            'continents' => $continents
        ]);
    }
    #[Route('/continent/{id}', name: 'afficher_continent')]
    public function affichercontinent(Continent $continent ): Response
    {
        // $continent = $repository->findAll();
        return $this->render('continent/affichercontinent.html.twig', [
            'continent' => $continent
        ]);
    }
}
