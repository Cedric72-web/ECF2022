<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $activate = null;

    #[ORM\ManyToMany(targetEntity: ModuleStructure::class, mappedBy: 'module')]
    private Collection $moduleStructures;

    public function __construct()
    {
        $this->moduleStructures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isActivate(): ?bool
    {
        return $this->activate;
    }

    public function setActivate(bool $activate): self
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * @return Collection<int, ModuleStructure>
     */
    public function getModuleStructures(): Collection
    {
        return $this->moduleStructures;
    }

    public function addModuleStructure(ModuleStructure $moduleStructure): self
    {
        if (!$this->moduleStructures->contains($moduleStructure)) {
            $this->moduleStructures->add($moduleStructure);
            $moduleStructure->addModule($this);
        }

        return $this;
    }

    public function removeModuleStructure(ModuleStructure $moduleStructure): self
    {
        if ($this->moduleStructures->removeElement($moduleStructure)) {
            $moduleStructure->removeModule($this);
        }

        return $this;
    }
}
