<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\WorkUnitRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=WorkUnitRepository::class)
 * @ApiResource(
 * subresourceOperations={
 *   "api_companies_work_units_get_subresource"={
 *      "normalization_context"={"groups"={"workUnits_subresource"}}
 *   }
 * },
 *  normalizationContext={
 *      "groups"={"workUnits_read"}
 *  }
 * )
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 */
class WorkUnit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workUnits_read","workUnits_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"workUnits_read","workUnits_subresource"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"workUnits_read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="workUnit")
     * @Groups({"workUnits_read"})
     */
    private $company;

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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
