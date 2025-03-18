<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $c1=new Categorie();
        $c1->setLibelle("Fruits")
        ->setImage("fruits.jpg");

        $manager->persist($c1);

        $c2=new Categorie();
        $c2->setLibelle("Legumes")
        ->setImage("legumes.jpg");

        $manager->persist($c2);

        $alimentRepository=$manager->getRepository(Aliment::class);
        $a1=$alimentRepository->findOneBy(['nom'=>'Carotte']);
        $a1->setCategorie($c2);

        $manager->persist($a1);

        $alimentRepository=$manager->getRepository(Aliment::class);
        $a2=$alimentRepository->findOneBy(['nom'=>'Patate']);
        $a2->setCategorie($c2);

        $manager->persist($a2);

        $alimentRepository=$manager->getRepository(Aliment::class);
        $a3=$alimentRepository->findOneBy(['nom'=>'Tomate']);
        $a3->setCategorie($c1);

        $manager->persist($a3);

        $alimentRepository=$manager->getRepository(Aliment::class);
        $a4=$alimentRepository->findOneBy(['nom'=>'Pomme']);
        $a4->setCategorie($c1);

        $manager->persist($a4);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
