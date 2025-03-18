<?php

namespace App\Controller\admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;


final class AdminAlimentController extends AbstractController
{
    #[Route('/admin', name: 'affich_admin')]
    public function admin(AlimentRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin_aliment/admin.html.twig', [
            'aliments' => $aliments,
        ]);
    }

#[Route('/admin/aliment/creation', name: 'creation_admin')]
#[Route('/admin/aliment/{id}', name: 'modif_admin', methods: ['GET', 'POST'])]
public function ajoutEtModifAdmin(?Aliment $aliment, Request $request, EntityManagerInterface $objectManager, AlimentRepository $repository): Response
{
    if (!$aliment) {
        $aliment = new Aliment();
    }

    $form = $this->createForm(AlimentType::class, $aliment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        if ($aliment->getImageFile()) {
            $aliment->setUpdatedAt(new \DateTimeImmutable());
        }

        $objectManager->persist($aliment);
        $objectManager->flush();

        $this->addFlash('success', $aliment->getId() ? 'La modification a été effectuée.' : 'Ajout réussi !');

        return $this->redirectToRoute("affich_admin");
    }

    return $this->render('admin_aliment/ajoutEtModifAdmin.html.twig', [
        "aliment" => $aliment,
        "form" => $form->createView(),
        "isModification" => $aliment->getId() !== null
    ]);
}


    #[Route('/admin/aliment/{id}/delete', name: 'admin_aliment_suppression', methods: ['POST'])]
public function suppression(Aliment $aliment, Request $request, EntityManagerInterface $objectManager): Response
{
    $tokenRecu = $request->request->get('_token');
    if ($this->isCsrfTokenValid("SUP" . $aliment->getId(), $tokenRecu)) {
        $objectManager->remove($aliment);
        $objectManager->flush();
        $this->addFlash('success', 'L\'aliment a bien été supprimé.');
    } else {
        $this->addFlash('error', 'Token CSRF invalide.');
    }
    return $this->redirectToRoute("affich_admin");
}

    
}
