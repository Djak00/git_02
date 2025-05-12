<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class RecetteController extends AbstractController
{
    /**
     *affiche recette
     *
     * @param RecetteRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/recette', name: 'recette', methods: ['GET'])]
    public function index(RecetteRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $recettes = $paginator->paginate(
            $repository->findBy(['user' => $this->getUser()]),
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('pages/recette/recette.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    /**
     * ajoute une nouvelle recette
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_USER')]
    #[Route('/recette/ajout', name: 'recette_ajout', methods: ['GET', 'POST'])]
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();
            $recette->setUser($this->getUser());

            $manager->persist($recette);
            $manager->flush();

            $this->addFlash(
                'success',
                'Recette ok !!'
            );

            return $this->redirectToRoute('recette');
        }

        return $this->render('pages/recette/recette.ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Recette $recette
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/recette/modification/{id}', name: 'recette_midification', methods: ['GET', 'POST'])]
    public function modification(Recette $recette, Request $request, EntityManagerInterface $manager): Response
    {

        if ($this->getUser() !== $recette->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de modifier cette recette.");
        }
        $form = $this->createForm(RecetteType::class, $recette);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recette = $form->getData();

            $manager->flush();

            $this->addFlash(
                'success',
                'Recette modifier !!'
            );

            return $this->redirectToRoute('recette');
        }


        return $this->render('pages/recette/recette.modification.html.twig', [

            'form' =>  $form->createView(),

        ]);
    }

    /**
     * suppr
     */
    #[Route('/recette/suppression/{id}', name: 'recette_suppression', methods: ['GET'])]
    public function suppression(Recette $recette, EntityManagerInterface $manager, Request $request): Response
    {

        $manager->remove($recette);

        $manager->flush();

        $this->addFlash('success', "La recette « {$recette->getNom()} » a bien été supprimé !");

        $page = $request->query->getInt('page', 1); // Récupère le numéro de page

        return $this->redirectToRoute('recette', ['page' => $page]); // Redirige vers la même page;
    }
}
