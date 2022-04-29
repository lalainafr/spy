<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Agent::class, inversedBy="missions")
     */
    private $agent;

    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="missions")
     * @ORM\JoinColumn(name="speciality_id", referencedColumnName="id", nullable=true,onDelete="SET NULL")
     */
    private $speciality;

    /**
     * @ORM\ManyToMany(targetEntity=Target::class, inversedBy="missions")
     */
    private $target;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->agent = new ArrayCollection();
        $this->target = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent[] = $agent;
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        $this->agent->removeElement($agent);

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @return Collection<int, Target>
     */
    public function getTarget(): Collection
    {
        return $this->target;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->target->contains($target)) {
            $this->target[] = $target;
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        $this->target->removeElement($target);

        return $this;
    }
}
