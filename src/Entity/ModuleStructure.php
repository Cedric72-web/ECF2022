<?php

namespace App\Entity;

use App\Repository\ModuleStructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleStructureRepository::class)]
class ModuleStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: partner::class, inversedBy: 'moduleStructures')]
    private Collection $partner;

    #[ORM\ManyToMany(targetEntity: Module::class, inversedBy: 'moduleStructures')]
    private Collection $module;

    public function __construct()
    {
        $this->partner = new ArrayCollection();
        $this->module = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, partner>
     */
    public function getPartner(): Collection
    {
        return $this->partner;
    }

    public function addPartner(partner $partner): self
    {
        if (!$this->partner->contains($partner)) {
            $this->partner->add($partner);
        }

        return $this;
    }

    public function removePartner(partner $partner): self
    {
        $this->partner->removeElement($partner);

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function addModule(Module $module): self
    {
        if (!$this->module->contains($module)) {
            $this->module->add($module);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        $this->module->removeElement($module);

        return $this;
    }
}
