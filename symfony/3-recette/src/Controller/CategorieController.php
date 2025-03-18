<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategorieController extends AbstractController
{
    #[Route('/categories', name: 'affich_categories')]
    public function categories(CategorieRepository $Repository): Response
    {
        $categories=$Repository->findAll();
        return $this->render('categorie/categories.html.twig', [
            'lesCategories'=>$categories
        ]);
    }

    // #[Route('/categories/admin', name: 'affich_adminCategories')]
    // public function adminCategories(CategorieRepository $Repository): Response
    // {
    //     $categories=$Repository->findAll();
    //     return $this->render('categorie/adminCategories.html.twig', [
    //         'lesCategories'=>$categories
    //     ]);
    // }
}
