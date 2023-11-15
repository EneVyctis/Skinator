<?php

namespace App\Entity;

use App\Entity\Member;
use App\Entity\Weapon;
use App\Repository\WardrobeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WardrobeRepository::class)]
class Wardrobe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'wardrobe', targetEntity: weapon::class)]
    private Collection $weapon;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'wardrobe')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Member $owner = null;

    public function __construct()
    {
        $this->weapon = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, weapon>
     */
    public function getWeapon(): Collection
    {
        return $this->weapon;
    }

    public function addWeapon(weapon $weapon): static
    {
        if (!$this->weapon->contains($weapon)) {
            $this->weapon->add($weapon);
            $weapon->setWardrobe($this);
        }

        return $this;
    }

    public function removeWeapon(weapon $weapon): static
    {
        if ($this->weapon->removeElement($weapon)) {
            // set the owning side to null (unless already changed)
            if ($weapon->getWardrobe() === $this) {
                $weapon->setWardrobe(null);
            }
        }

        return $this;
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

    public function getOwner(): ?Member
    {
        return $this->owner;
    }

    public function setOwner(?Member $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
