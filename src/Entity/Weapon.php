<?php

namespace App\Entity;

use App\Repository\WeaponRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponRepository::class)]
class Weapon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'weapon')]
    private ?Wardrobe $wardrobe = null;

    #[ORM\Column(length: 255)]
    private ?string $rarety = null;

    #[ORM\ManyToMany(targetEntity: Showcase::class, mappedBy: 'weapons')]
    private Collection $showcases;

    public function __construct()
    {
        $this->showcases = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWardrobe(): ?Wardrobe
    {
        return $this->wardrobe;
    }

    public function setWardrobe(?Wardrobe $wardrobe): static
    {
        $this->wardrobe = $wardrobe;

        return $this;
    }

    public function getRarety(): ?string
    {
        return $this->rarety;
    }

    public function setRarety(string $rarety): static
    {
        $this->rarety = $rarety;

        return $this;
    }

    /**
     * @return Collection<int, Showcase>
     */
    public function getShowcases(): Collection
    {
        return $this->showcases;
    }

    public function addShowcase(Showcase $showcase): static
    {
        if (!$this->showcases->contains($showcase)) {
            $this->showcases->add($showcase);
            $showcase->addWeapon($this);
        }

        return $this;
    }

    public function removeShowcase(Showcase $showcase): static
    {
        if ($this->showcases->removeElement($showcase)) {
            $showcase->removeWeapon($this);
        }

        return $this;
    }

}
