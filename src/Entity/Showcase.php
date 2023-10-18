<?php

namespace App\Entity;

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

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isPublic = null;

    #[ORM\ManyToOne(inversedBy: 'showcases')]
    private ?Member $creator = null;

    #[ORM\ManyToMany(targetEntity: Skin::class, inversedBy: 'showcases')]
    private Collection $skins;

    public function __construct()
    {
        $this->skins = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
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

    public function getCreator(): ?Member
    {
        return $this->creator;
    }

    public function setCreator(?Member $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, Skin>
     */
    public function getSkins(): Collection
    {
        return $this->skins;
    }

    public function addSkin(Skin $skin): static
    {
        if (!$this->skins->contains($skin)) {
            $this->skins->add($skin);
        }

        return $this;
    }

    public function removeSkin(Skin $skin): static
    {
        $this->skins->removeElement($skin);

        return $this;
    }
}
