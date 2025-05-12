<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Recette;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;


    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager,): void
    {
        // User
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null)
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
            $users[] = $user;
            $manager->persist($user);
        }
        $ingredients = [];

        // 50 ingrédients
        for ($i = 0; $i < 50; $i++) {
            $ingredient = new Ingredient();
            $ingredient->setNom($this->faker->word())
                ->setPrix(mt_rand(0, 100))
                ->setUser($users[mt_rand(0, count($users) - 1)]);

            $manager->persist($ingredient);
            $ingredients[] = $ingredient; // On les stocke dans un tableau
        }

        // 50 recettes
        for ($i = 0; $i < 50; $i++) {
            $recette = new Recette();
            $recette->setNom($this->faker->words(3, true))
                ->setTemps(mt_rand(1, 24))
                ->setNbrPersonnes(mt_rand(1, 50))
                ->setDificulte(mt_rand(1, 5))
                ->setDescription($this->faker->text(300))
                ->setPrix(mt_rand(1, 1000))
                ->setFavorite(mt_rand(0, 1) === 1)
                ->setUser($users[mt_rand(0, count($users) - 1)]);

            // ajoute entre 5 et 15 ingrédients aléatoires
            for ($j = 0; $j < mt_rand(5, 15); $j++) {
                $recette->addListeIngredient(
                    $ingredients[mt_rand(0, count($ingredients) - 1)]
                );
            }

            $manager->persist($recette);
        }



        $manager->flush();
    }
}
