<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlimentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $aliment01 = new Aliment();
        $aliment01->setNom("Carotte")
            ->setPrix("1.8")
            ->setImage("aliments/carotte.png")
            ->setCalorie("36")
            ->setProteine("0.77")
            ->setGlucide("6.45")
            ->setLipide("0.26");
        $manager->persist($aliment01);

        $aliment02 = new Aliment();
        $aliment02->setNom("Patate")
            ->setPrix("1.5")
            ->setImage("aliments/patate.jpg")
            ->setCalorie("80")
            ->setProteine("1.8")
            ->setGlucide("16.7")
            ->setLipide("0.34");
        $manager->persist($aliment02);

        $aliment03 = new Aliment();
        $aliment03->setNom("Tomate")
            ->setPrix("2.3")
            ->setImage("aliments/tomate.png")
            ->setCalorie("18")
            ->setProteine("0.86")
            ->setGlucide("2.26")
            ->setLipide("0.24");
        $manager->persist($aliment03);

        $aliment04 = new Aliment();
        $aliment04->setNom("Pomme")
            ->setPrix("2.35")
            ->setImage("aliments/pomme.png")
            ->setCalorie("52")
            ->setProteine("0.25")
            ->setGlucide("11.6")
            ->setLipide("0.25");
        $manager->persist($aliment04);

        


        $manager->flush();
    }
}
