<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min: 2, max: 50)]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\Range(min: 1, max: 24)]
    #[ORM\Column(nullable: true)]
    private ?float $temps = null;

    #[Assert\Range(min: 0, max: 50)]
    #[ORM\Column(nullable: true)]
    private ?int $nbr_personnes = null;

    #[Assert\Range(min: 0, max: 5)]
    #[ORM\Column(nullable: true)]
    private ?int $dificulte = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\Range(min: 0, max: 1000)]
    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $favorite = false;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $date_createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    #[ORM\JoinTable(name: 'recette_ingredient')]
    private Collection $liste_ingredients;

    public function __construct()
    {
        $this->date_createdAt = new \DateTimeImmutable();
        $this->liste_ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getTemps(): ?float
    {
        return $this->temps;
    }

    public function setTemps(?float $temps): static
    {
        $this->temps = $temps;
        return $this;
    }

    public function getNbrPersonnes(): ?int
    {
        return $this->nbr_personnes;
    }

    public function setNbrPersonnes(?int $nbr_personnes): static
    {
        $this->nbr_personnes = $nbr_personnes;
        return $this;
    }

    public function getDificulte(): ?int
    {
        return $this->dificulte;
    }

    public function setDificulte(?int $dificulte): static
    {
        $this->dificulte = $dificulte;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function isFavorite(): ?bool
    {
        return $this->favorite;
    }

    public function setFavorite(?bool $favorite): static
    {
        $this->favorite = $favorite;
        return $this;
    }

    public function getDateCreatedAt(): ?\DateTimeImmutable
    {
        return $this->date_createdAt;
    }

    public function setDateCreatedAt(?\DateTimeImmutable $date_createdAt): static
    {
        $this->date_createdAt = $date_createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getListeIngredients(): Collection
    {
        return $this->liste_ingredients;
    }

    public function addListeIngredient(Ingredient $ingredient): static
    {
        if (!$this->liste_ingredients->contains($ingredient)) {
            $this->liste_ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeListeIngredient(Ingredient $ingredient): static
    {
        $this->liste_ingredients->removeElement($ingredient);
        return $this;
    }
}
