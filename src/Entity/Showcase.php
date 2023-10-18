<?php

namespace App\Entity;

use App\Entity\Wardrobe;
use App\Entity\Member;
use App\Entity\Skin;
use App\Repository\ShowcaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShowcaseRepository::class)]
class Showcase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isPublic = null;

    #[ORM\OneToMany(mappedBy: 'showcase', targetEntity: wardrobe::class)]
    private Collection $creator;

    #[ORM\ManyToMany(targetEntity: skin::class, inversedBy: 'showcases')]
    private Collection $skins;

    #[ORM\Column(length: 255)]
    private ?string $name = null;   

    public function __construct()
    {
        $this->creator = new ArrayCollection();
        $this->skins = new ArrayCollection();
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

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * @return Collection<int, wardrobe>
     */
    public function getCreator(): Collection
    {
        return $this->creator;
    }

    public function addCreator(wardrobe $creator): static
    {
        if (!$this->creator->contains($creator)) {
            $this->creator->add($creator);
            $creator->setShowcase($this);
        }

        return $this;
    }

    public function removeCreator(wardrobe $creator): static
    {
        if ($this->creator->removeElement($creator)) {
            // set the owning side to null (unless already changed)
            if ($creator->getShowcase() === $this) {
                $creator->setShowcase(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, skin>
     */
    public function getSkins(): Collection
    {
        return $this->skins;
    }

    public function addSkin(skin $skin): static
    {
        if (!$this->skins->contains($skin)) {
            $this->skins->add($skin);
        }

        return $this;
    }

    public function removeSkin(skin $skin): static
    {
        $this->skins->removeElement($skin);

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
}
