<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


final class AdminSecuController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $requeteForm, EntityManagerInterface $bdd,UserPasswordHasherInterface  $encoder): Response
    {

        $utilisateur=new Utilisateur();
        $form=$this->createForm(InscriptionType::class,$utilisateur);

        $form->handleRequest($requeteForm);
        if ($form->isSubmitted() && $form->isValid()) {
            $mdpCrypter=$encoder->hashPassword($utilisateur,$utilisateur->getPassword());
            $utilisateur->setPassword($mdpCrypter);
            $bdd->persist($utilisateur);
            $bdd->flush();
            return $this->redirectToRoute("affich_aliments");
        }

        return $this->render('admin_secu/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'connexion')]
    public function login(AuthenticationUtils $util): Response
    {

        return $this->render('admin_secu/login.html.twig', [
            "lastUserName"=> $util ->getLastUsername(),
            "error"=> $util ->getLastAuthenticationError(),
        ]);
    }

    #[Route('/logout', name: 'deconnexion')]
    public function deconnexion(): void
    {



    }
}

