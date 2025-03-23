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
        $categories = $repo->findAll();
        return $this->render('admin_categorie/adminCategories.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/categorie/ajout', name: 'affich_ajoutCategorie', methods: ['GET', 'POST'])]
    #[Route('/admin/categorie/{id}', name: 'affich_modifCategorie', methods: ['GET', 'POST'])]
    public function adminCategoriesModifAjout(?Categorie $categorie, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$categorie) {
            $categorie = new Categorie();
        }
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $entityManagerInterface->persist($categorie);

            $entityManagerInterface->flush();
            // dd("Après addFlash, avant redirection");
            $this->addFlash('success', "L'action a été réalisée");

            return $this->redirectToRoute("affich_adminCategories", [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categorie/adminCategoriesModifAjout.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/categorie/supp/{id}', name: 'supp_Categories', methods: ['POST'])]
    public function suppCategories(Categorie $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('nomToken_categorie' . $categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Échec de la suppression.');
        }

        return $this->redirectToRoute("affich_adminCategories");
    }
}
