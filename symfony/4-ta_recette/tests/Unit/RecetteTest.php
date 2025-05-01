<?php

namespace App\Tests\Unit;

use App\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecetteTest extends KernelTestCase
{

    public function getEntity(): Recette
    {
        return (new Recette())
            ->setNom('nom_01')
            ->setDescription('Description_01')
            ->setFavorite(true)
            ->setDateCreatedAt(new \DateTimeImmutable)
            ->setUpdatedAt(new \DateTimeImmutable);
    }
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $recette = $this->getEntity();

        $errors = $container->get('validator')->validate($recette);

        $this->assertCount(0, $errors);
    }

    public function testInvalidName(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $recette = new Recette();
        $recette->setNom('setNom_01')
            ->setDescription('Description_01')
            ->setFavorite(true)
            ->setDateCreatedAt(new \DateTimeImmutable)
            ->setUpdatedAt(new \DateTimeImmutable);

        $errors = $container->get('validator')->validate($recette);

        $this->assertCount(0, $errors);
    }
}
