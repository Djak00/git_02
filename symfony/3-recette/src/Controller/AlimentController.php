<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class AlimentController extends AbstractController
{
    #[Route('/', name: 'affich_aliments')]
    public function aliments(AlimentRepository $alimentRepository): Response
    {
        $aliments=$alimentRepository->findAll();
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' =>false
            
        ]);
    }

    #[Route('/calorie/{calorie}', name: 'affich_calorie')]
    public function getAlimentCalorie(AlimentRepository $alimentRepository, int $calorie): Response
    {
        $aliments=$alimentRepository->getAlimentParProprietes('calorie','<',$calorie);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' =>true
        ]);
    }

    #[Route('/glucide/{glucide}', name: 'affich_glucide')]
    public function getAlimentGlucide(AlimentRepository $alimentRepository, int $glucide): Response
    {
        $aliments=$alimentRepository->getAlimentParProprietes('glucide','>',$glucide);
        return $this->render('aliment/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' =>true
        ]);
    }



}
