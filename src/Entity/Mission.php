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

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="missions")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="missions")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Hideout::class, inversedBy="missions")
     */
    private $Hideout;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="missions")
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity=Contact::class, inversedBy="missions")
     */
    private $contact;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function __construct()
    {
        $this->agent = new ArrayCollection();
        $this->target = new ArrayCollection();
        $this->Hideout = new ArrayCollection();
        $this->contact = new ArrayCollection();
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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Hideout>
     */
    public function getHideout(): Collection
    {
        return $this->Hideout;
    }

    public function addHideout(Hideout $hideout): self
    {
        if (!$this->Hideout->contains($hideout)) {
            $this->Hideout[] = $hideout;
        }

        return $this;
    }

    public function removeHideout(Hideout $hideout): self
    {
        $this->Hideout->removeElement($hideout);

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact[] = $contact;
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        $this->contact->removeElement($contact);

        return $this;
    }
}
