<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class AdminCategorieController extends AbstractController
{
    #[Route('/admin/categorie', name: 'affich_adminCategories')]
    public function index(CategorieRepository $repo): Response
    {
        $categories=$repo->findAll();
        return $this->render('admin_categorie/adminCategories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/categorie/ajout', name: 'affich_ajoutCategorie')]
    #[Route('/admin/categorie/{id}', name: 'affich_modifCategorie')]
    public function adminCategoriesModifAjout(?Categorie $categorie,Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$categorie) {
            $categorie=new Categorie();
        }
        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($categorie);
            $entityManagerInterface->flush();
            $this->addFlash('success', "L'action a été réalisée");
            return $this->redirectToRoute("affich_adminCategories");
        }

        return $this->render('admin_categorie/adminCategoriesModifAjout.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
}
