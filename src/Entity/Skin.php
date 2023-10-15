<?php

namespace App\Entity;

use App\Repository\SkinRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkinRepository::class)]
class Skin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'skin')]
    private ?Wardrobe $wardrobe = null;

    #[ORM\Column(length: 255)]
    private ?string $rarety = null;

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

}
