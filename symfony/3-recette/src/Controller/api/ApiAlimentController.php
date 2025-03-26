<?php

namespace App\Controller\api;

use App\Entity\Aliment;
use Doctrine\ORM\EntityManager;
use App\Repository\AlimentRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use PHPUnit\Framework\ComparisonMethodDoesNotDeclareBoolReturnTypeException;

final class ApiAlimentController extends AbstractController
{
    #[Route('/api/aliments', name: 'api_aliments',  methods: ['GET'])]
    public function getAliments(AlimentRepository $alimentRepository): JsonResponse
    {

        $aliments = $alimentRepository->findAll();

        $objetTab = [];

        foreach ($aliments as $aliment) {
            $objetTab[] = [
                'id' => $aliment->getId(),
                'nom' => $aliment->getNom(),
                'prix' => $aliment->getPrix(),
                'calorie' => $aliment->getCalorie(),
                'proteine' => $aliment->getProteine(),
                'glucide' => $aliment->getGlucide(),
                'lipide' => $aliment->getLipide(),
                'categorie' => $aliment->getCategorie()?->getLibelle()
            ];
        }

        return $this->json($objetTab);
    }

    #[Route('/api/aliment/{id}', name: 'api_aliment_id',  methods: ['GET'])]
    public function getAlimentsParId(int $id, AlimentRepository $alimentRepository): JsonResponse
    {

        $aliment = $alimentRepository->find($id);

        if (!$aliment) {

            return $this->json(['message' => 'Aliment non valide'], 404);
        };


        $objetTab[] = [
            'id' => $aliment->getId(),
            'nom' => $aliment->getNom(),
            'prix' => $aliment->getPrix(),
            'calorie' => $aliment->getCalorie(),
            'proteine' => $aliment->getProteine(),
            'glucide' => $aliment->getGlucide(),
            'lipide' => $aliment->getLipide(),
            'categorie' => $aliment->getCategorie()?->getLibelle()
        ];


        return $this->json($objetTab);
    }

    #[Route('/api/aliments/ajout', name: 'api_aliment_creer',  methods: ['POST'])]
    public function creerAliment(Request $requeteFormClient, EntityManagerInterface $manipLaBdd, CategorieRepository $trouvCategorieDansBdd): JsonResponse
    {
$tab=json_decode($requeteFormClient->getContent(),true);

if (!$tab || !isset($tab['nom'], $tab['prix'], $tab['categorie_id'])) {
    return $this->json(['message' => 'Données invalides'], 400);
};

$aliment = new Aliment();
$aliment->setNom($tab['nom']);
$aliment->setPrix($tab['prix']);

$categorie = $trouvCategorieDansBdd->find($tab['categorie_id']);
if (!$categorie) {
    return $this->json(['message' => '(categorie 1 ou 2)'], 404);
}
$aliment->setCategorie($categorie);

$manipLaBdd->persist($aliment);
$manipLaBdd->flush();

return $this->json(['message' => 'Aliment ajouté !'], 201);


    }

    #[Route('/api/aliment/suppr/{id}', name: 'suppr_aliment_id',  methods: ['DELETE'])]
    public function supprAlimentsParId(int $id,EntityManagerInterface $manipLaBdd, AlimentRepository $trouvCategorieDansBdd): JsonResponse
    {

        $aliment = $trouvCategorieDansBdd->find($id);

        if (!$aliment) {

            return $this->json(['message' => 'Aliment non valide'], 404);
        };

        $manipLaBdd->remove( $aliment);
        $manipLaBdd->flush();


        return $this->json(["message" => "Aliment supprimé !"]);
    }

    #[Route('/api/aliment/suppr/{id}', name: 'suppr_aliment_id',  methods: ['DELETE'])]
    public function modifAlimentsParId(int $id,EntityManagerInterface $manipLaBdd, AlimentRepository $trouvCategorieDansBdd): JsonResponse
    {

        $aliment = $trouvCategorieDansBdd->find($id);

        if (!$aliment) {

            return $this->json(['message' => 'Aliment non valide'], 404);
        };

        $manipLaBdd->remove( $aliment);
        $manipLaBdd->flush();


        return $this->json(["message" => "Aliment supprimé !"]);
    }


#[Route('/api/aliment/modif/{id}', name: 'modif_aliment', methods: ['PUT'])]
public function modifierAlimentParId(
    Request $requeteHTTP, int $id, EntityManagerInterface $gestionnaireBDD,AlimentRepository $entrepotAliment, CategorieRepository $entrepotCategorie): JsonResponse {

    $corpsRequeteJSON = $requeteHTTP->getContent();

    $requeteTransfoEnTableau = json_decode($corpsRequeteJSON, true);

    $alimentAChanger = $entrepotAliment->find($id);

    if (!$alimentAChanger) {
        return $this->json(['message' => 'Aliment non trouvé dans la base'], 404);
    }


    if (isset($requeteTransfoEnTableau['nom'])) {
        $alimentAChanger->setNom($requeteTransfoEnTableau['nom']);
    }
    if (isset($requeteTransformeeEnTableau['prix'])) {
        $alimentAChanger->setPrix($requeteTransfoEnTableau['prix']);
    }
    if (isset($requeteTransfoEnTableau['categorie_id'])) {
        $nouvelleCategorie = $entrepotCategorie->find($requeteTransfoEnTableau['categorie_id']);

        if (!$nouvelleCategorie) {
            return $this->json(['message' => 'Catégorie introuvable'], 404);
        }

        $alimentAChanger->setCategorie($nouvelleCategorie);
    }

    $gestionnaireBDD->flush();

    return $this->json(['message' => 'Aliment modifié avec succès']);
}

    
}
