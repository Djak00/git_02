<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserListener
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function prePersist(User $user): void
    {
        $this->encodePassword($user);
        $user->setUpdatedAt(new \DateTimeImmutable());
    }

    public function preUpdate(User $user): void
    {
        $this->encodePassword($user);
        $user->setUpdatedAt(new \DateTimeImmutable());
    }

    /**
     * Encode the plain password if it's defined.
     */
    private function encodePassword(User $user): void
    {
        if (null === $user->getPlainPassword()) {
            return;
        }

        $hashedPassword = $this->hasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashedPassword);


        $user->setPlainPassword(null);
    }
}
