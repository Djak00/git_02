<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserController extends AbstractController
{

    //UTILISATEUR PEUT MODIF SON NOM ET PSEUDO AV CONFIR DE MDP
    #[Route('/utilisateur/modification/{id}', name: 'modification', methods: (['GET', 'POST']))]
    public function edit(
        User $choosenUser,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher,

    ): Response {

        if ($this->getUser() !== $choosenUser) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de modifier un autre utilisateur ");
        }

        $form = $this->createForm(UserType::class, $choosenUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($choosenUser, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Les informations de votre compte ont bien été modifiées.'
                );

                return $this->redirectToRoute('recette');
            } else {

                $this->addFlash(
                    'warning',
                    'Le mot de passe est incorrect.'
                );
            }
        }
        return $this->render('pages/user/utilisateur_modification.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * UTILISATEUR MODIF SON MDP
     *
     * @param User $choosenUser
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/utilisateur/modification-mot-de-passe/{id}', name: 'utilisateur.modification.password', methods: ['GET', 'POST'])]
    public function editPassword(
        User $choosenUser,
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager
    ): Response {

        if ($this->getUser() !== $choosenUser) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit.");
        }

        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $currentPassword = $form->get('currentPassword')->getData();
            $newPassword = $form->get('newPassword')->getData(); // Géré par RepeatedType

            if ($hasher->isPasswordValid($choosenUser, $currentPassword)) {
                // Mise à jour du mot de passe
                $choosenUser->setUpdatedAt(new \DateTimeImmutable());
                $choosenUser->setPlainPassword($newPassword); // Le Listener va hasher le mot de passe

                $manager->persist($choosenUser);
                $manager->flush();

                $this->addFlash('success', 'Mot de passe modifié avec succès.');
                return $this->redirectToRoute('recette');
            } else {
                $this->addFlash('warning', 'Le mot de passe actuel est incorrect.');
            }
        }

        return $this->render('pages/user/modification_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
