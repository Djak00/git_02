<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Dispose>
     */
    #[ORM\OneToMany(targetEntity: Dispose::class, mappedBy: 'personne')]
    private Collection $disposes;

    public function __construct()
    {
        $this->disposes = new ArrayCollection();
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

    /**
     * @return Collection<int, Dispose>
     */
    public function getDisposes(): Collection
    {
        return $this->disposes;
    }

    public function addDispose(Dispose $dispose): static
    {
        if (!$this->disposes->contains($dispose)) {
            $this->disposes->add($dispose);
            $dispose->setPersonne($this);
        }

        return $this;
    }

    public function removeDispose(Dispose $dispose): static
    {
        if ($this->disposes->removeElement($dispose)) {
            // set the owning side to null (unless already changed)
            if ($dispose->getPersonne() === $this) {
                $dispose->setPersonne(null);
            }
        }

        return $this;
    }
}
