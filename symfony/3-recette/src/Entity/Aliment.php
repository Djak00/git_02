<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AlimentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: AlimentRepository::class)]
#[Vich\Uploadable]  // Activation de VichUploaderBundle
class Aliment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères',
    )]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(
        min: 1,
        max: 10,
        notInRangeMessage: "La valeur doit être comprise entre {{ min }} et {{ max }}."
    )]    
    private ?float $prix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: "aliment_images", fileNameProperty: "image")]
    private ?File $imageFile = null; // Ne sera pas stocké en BDD

    #[ORM\Column(name: "updated_at", nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $calorie = null;

    #[ORM\Column(nullable: true)]
    private ?float $proteine = null;

    #[ORM\Column(nullable: true)]
    private ?float $glucide = null;

    #[ORM\Column(nullable: true)]
    private ?float $lipide = null;

    #[ORM\ManyToOne(inversedBy: 'aliments')]
    private ?Categorie $categorie = null;

    // GETTERS & SETTERS

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            // ✅ Mise à jour de la date pour forcer Doctrine à sauvegarder les changements
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getCalorie(): ?int
    {
        return $this->calorie;
    }

    public function setCalorie(?int $calorie): static
    {
        $this->calorie = $calorie;
        return $this;
    }

    public function getProteine(): ?float
    {
        return $this->proteine;
    }

    public function setProteine(?float $proteine): static
    {
        $this->proteine = $proteine;
        return $this;
    }

    public function getGlucide(): ?float
    {
        return $this->glucide;
    }

    public function setGlucide(?float $glucide): static
    {
        $this->glucide = $glucide;
        return $this;
    }

    public function getLipide(): ?float
    {
        return $this->lipide;
    }

    public function setLipide(?float $lipide): static
    {
        $this->lipide = $lipide;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
