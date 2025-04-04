<?php

namespace App\Tests\Entity;


use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEntityTest extends KernelTestCase
{
    private const IDENTICALTO = "les mdp ne sont pas identiques";
    private const LENGTH_MESSAGE = "Votre nom doit contenir au moins 5 caractères";
    private const VALID_PASSWORD = 'passValid';

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testUserEntityIsValid(): void
    {
        $user = new Utilisateur();
        $user->setUsername("Jean");
        $user->setPassword(self::VALID_PASSWORD);
        $user->setVerificationPassword(self::VALID_PASSWORD);

        $errors = $this->validator->validate($user);
        $this->assertCount(0, $errors);
    }

    public function testPasswordIdentique(): void
    {
        $user = new Utilisateur();
        $user->setUsername("Paul");
        $user->setPassword("azerty");
        $user->setVerificationPassword("autre");

        $errors = $this->validator->validate($user);
        $this->assertGreaterThan(0, count($errors));


    }
}
