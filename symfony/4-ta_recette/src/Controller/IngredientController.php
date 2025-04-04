<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class IngredientController extends AbstractController
{

    /**
     * affichage des ingredients
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient')]
    public function index(IngredientRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {

        $ingredients = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        // dd($ingredient);
        return $this->render('pages/ingredient/ingredient.html.twig', [
            'ingredients' =>  $ingredients,
        ]);
    }


    /**
     * ajout d'ingredient
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/ingredient/ajout', name: 'ingredient_ajout', methods: ['GET', 'POST'])]
    public function ingredientAjout(Request $request, EntityManagerInterface $manager): Response
    {

        $ingredient = new Ingredient();

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Ingrédient ajouté !!'
            );

            return $this->redirectToRoute('ingredient');
        }

        return $this->render('pages/ingredient/ingredient.ajout.html.twig', [
            'form' =>  $form->createView(),
        ]);
    }

    // #[Route('/ingredient/modification/{id}', name: 'ingredient_modification', methods: ['GET', 'POST'])]
    // public function modification(int $id, IngredientRepository $repository): Response
    // {
    //     $ingredient = $repository->findBy(['id' => $id]);
    //     $form = $this->createForm(IngredientType::class, $ingredient);


    //     return $this->render('pages/ingredient/ingredient.modification.html.twig', [

    //         'form' =>  $form->createView(),

    //     ]);
    // }





    #[Route('/ingredient/modification/{id}', name: 'ingredient_modification', methods: ['GET', 'POST'])]
    public function modification(Ingredient $ingredient, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->flush();

            $this->addFlash(
                'success',
                'Ingrédient modifier !!'
            );

            return $this->redirectToRoute('ingredient');
        }


        return $this->render('pages/ingredient/ingredient.modification.html.twig', [

            'form' =>  $form->createView(),

        ]);
    }


    #[Route('/ingredient/suppression/{id}', name: 'ingredient_suppression', methods: ['GET'])]
    public function suppression(Ingredient $ingredient, EntityManagerInterface $manager, Request $request): Response
    {

        $manager->remove($ingredient);

        $manager->flush();

        $this->addFlash('success', "L'ingrédient « {$ingredient->getNom()} » a bien été supprimé !");

        $page = $request->query->getInt('page', 1); // Récupère le numéro de page

        return $this->redirectToRoute('ingredient', ['page' => $page]); // Redirige vers la même page;
    }
}
