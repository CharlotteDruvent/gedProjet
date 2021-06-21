<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 * @ApiResource(
 *  normalizationContext={
 *      "groups"={"companys_read"}
 *  }
 * )
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"companys_read","workUnits_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"companys_read","workUnits_read"})
     * @Assert\NotBlank(message="Le nom de l'entreprise est obligatoire !")
     * @Assert\Length(min=2, minMessage="Minimum 2 caractères")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"companys_read","workUnits_read"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"companys_read"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"companys_read"})
     */
    private $zipCode;

    /**
     * @ORM\OneToMany(targetEntity=WorkUnit::class, mappedBy="company")
     * @Groups({"companys_read"})
     * @ApiSubresource
     */
    private $workUnit;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="companys")
     * @Groups({"companys_read"})
     */
    private $users;

    public function __construct()
    {
        $this->workUnit = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return Collection|WorkUnit[]
     */
    public function getWorkUnit(): Collection
    {
        return $this->workUnit;
    }

    public function addWorkUnit(WorkUnit $workUnit): self
    {
        if (!$this->workUnit->contains($workUnit)) {
            $this->workUnit[] = $workUnit;
            $workUnit->setCompany($this);
        }

        return $this;
    }

    public function removeWorkUnit(WorkUnit $workUnit): self
    {
        if ($this->workUnit->removeElement($workUnit)) {
            // set the owning side to null (unless already changed)
            if ($workUnit->getCompany() === $this) {
                $workUnit->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCompany($this);
        }

        return $this;
    }
}
