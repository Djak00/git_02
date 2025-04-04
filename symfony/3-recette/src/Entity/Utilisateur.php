<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields:['username'], message: 'Ce nom existe déjà')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères',
    )]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères',
    )]
    
    private ?string $password = null;

    
    #[Assert\Length(
        min: 2,
        max: 10,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\IdenticalTo(
        propertyPath:"password",message:"les mdp ne sont pas identiques"
    )]
    private ?string $verificationPassword = null;

    #[ORM\Column(length: 255)]
    private ?string $roles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    // remplace getUsername
    public function getUserIdentifier(): string
{
    return $this->username;
}

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getVerificationPassword(): ?string
    {
        return $this->verificationPassword;
    }

    public function setVerificationPassword(string $verificationPassword): static
    {
        $this->verificationPassword = $verificationPassword;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si tu stockais des données sensibles (ex : mot de passe en clair), tu les nettoierais ici.
    }
    public function getSalt()
    {
        
    }
    public function getRoles(): array
    {
        return [$this->roles];
    }

    public function setRoles(?string $roles): static
    {
        if ($roles===null) {
            $this->roles = "ROLE_USER";
        }
        else {
            $this->roles = $roles;
        }

        return $this;
    }
}
