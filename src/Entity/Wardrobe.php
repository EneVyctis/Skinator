<?php

namespace App\Entity;

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

    #[ORM\OneToMany(mappedBy: 'wardrobe', targetEntity: skin::class)]
    private Collection $skin;

    public function __construct()
    {
        $this->skin = new ArrayCollection();
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
     * @return Collection<int, skin>
     */
    public function getSkin(): Collection
    {
        return $this->skin;
    }

    public function addSkin(skin $skin): static
    {
        if (!$this->skin->contains($skin)) {
            $this->skin->add($skin);
            $skin->setWardrobe($this);
        }

        return $this;
    }

    public function removeSkin(skin $skin): static
    {
        if ($this->skin->removeElement($skin)) {
            // set the owning side to null (unless already changed)
            if ($skin->getWardrobe() === $this) {
                $skin->setWardrobe(null);
            }
        }

        return $this;
    }
}
