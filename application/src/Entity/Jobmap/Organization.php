<?php

namespace App\Entity\Jobmap;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Interfaces\OwnerableInterface;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Entity\User;
use App\Entity\ACL\SecurityOrganization;
use App\Entity\Jobmap\OrganizationLocation;
use App\Entity\Jobmap\Inventory;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

use App\Controller\Api\OrgApiController;
use App\Controller\Api\OrgApiUpdateController;
use App\Controller\Api\OrgApiDeleteController;
use App\Controller\Api\OrgApiAllController;
use App\Controller\Api\OrgApiSingleController;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Jobmap\OrganizationRepository")
 * @ApiResource(
 *      attributes = {
 *          "input_formats"={
 *              "json" = {"application/json"}
 *          }, 
 *          "output_formats"={
 *              "json"= {"application/json"}
 *          } 
 *      },
 *      collectionOperations = {
 *          "get" = {
 *              "method" = "GET",
 *              "path" = "/organizations.{_format}",
 *              "controller" = OrgApiAllController::class
 *          },
 *          "post" = {
 *              "method" = "POST",
 *              "path" = "/organizations.{_format}",
 *              "controller" = OrgApiController::class
 *          }
 *      },
 *      itemOperations = {
 *          "get" = {
 *              "method" = "GET",
 *              "path" = "/organizations/{id}.{_format}",
 *              "controller" = OrgApiSingleController::class
 *          },
 *          "patch" = {
 *              "method" = "PATCH",
 *              "path" = "/organizations/{id}.{_format}",
 *              "controller" = OrgApiUpdateController::class
 *          },
 *          "delete" = {
 *              "method" = "DELETE",
 *              "path" = "/organizations/{id}.{_format}",
 *              "controller" = OrgApiDeleteController::class
 *          }
 *      }
 * )
 * @ORM\Table(name="jobmap_organizations")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Organization implements OwnerableInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     * @Assert\NotBlank(
     *      message = "The organization name can not be blank"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Choice({
     *   "Sole Proprietor",
     *   "Partnership (General, LP, LLP, or PLLP)",
     *   "Limited Liability Company",
     *   "Corporation (C, S, or professional)",
     *   "Government agency"
     * })
     */
    private $entityType;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     * @Assert\Length(min=10, max=1000)
     */
    private $missionStatement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned
     * @Assert\GreaterThanOrEqual(0)
     */
    private $totalEmployees;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Gedmo\Versioned
     */
    private $financialYearEnds;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $naicsMajor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $naicsMinor;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="organization", cascade={"persist"})
     * @Gedmo\Versioned
     * @ORM\JoinColumn(nullable=false)
     */
    private $administrator;

    /**
     * @var Collection|Inventory[]
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="organization", cascade={"persist", "remove"})
     */
    private $inventories;

    /**
     * @var Collection|OrganizationLocation[]
     * @ORM\OneToMany(targetEntity=OrganizationLocation::class, mappedBy="organization", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $locations;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Gedmo\Versioned
     */
    private $annualRevenue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned
     * @Assert\Range(min=0,max=120)
     */
    private $fullTimeHoursPerWeek;

    /**
     * @ var SecurityOrganization
     * @ ORM\OneToOne(targetEntity=SecurityOrganization::class, cascade={"persist", "remove"})
     */
    protected $securityOrganization;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     * @Assert\Length(min=10, max=1000)
     */
    private $valueProposition;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Regex(pattern="/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i", message="Invalid Website URL")
     */
    private $websiteURL;
    
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Regex(pattern="/^[\(]?[\+]?[1-9]{0,1}[0-9]{0,2}[\)]?[\-\s]?[\(]?[0-9]{3,4}[\)]?[\-\s]?[0-9]{3}[\-\s]?[0-9]{4}$/", message="Invalid Phone number")
     */
    private $mainPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Email
     */
    private $mainEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $businessHours;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     * @Assert\Date
     */
    private $dateFounded;
    
    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->securityOrganization = new SecurityOrganization($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        return $this->id = $id;
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

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(?string $entityType): self
    {
        $this->entityType = $entityType;

        return $this;
    }

    public function getMissionStatement(): ?string
    {
        return $this->missionStatement;
    }

    public function setMissionStatement(?string $missionStatement): self
    {
        $this->missionStatement = $missionStatement;

        return $this;
    }

    public function getTotalEmployees(): ?int
    {
        return $this->totalEmployees;
    }

    public function setTotalEmployees(?int $totalEmployees): self
    {
        $this->totalEmployees = $totalEmployees;

        return $this;
    }

    public function getFinancialYearEnds(): ?string
    {
        return $this->financialYearEnds;
    }

    public function setFinancialYearEnds(?string $financialYearEnds): self
    {
        $this->financialYearEnds = $financialYearEnds;

        return $this;
    }

    public function getNaicsMajor(): ?string
    {
        return $this->naicsMajor;
    }

    public function setNaicsMajor(?string $naicsMajor): self
    {
        $this->naicsMajor = $naicsMajor;

        return $this;
    }

    public function getNaicsMinor(): ?string
    {
        return $this->naicsMinor;
    }

    public function setNaicsMinor(?string $naicsMinor): self
    {
        $this->naicsMinor = $naicsMinor;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->administrator;
    }

    public function setOwner(?User $administrator): OwnerableInterface
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerId()
    {
        return null !== $this->getOwner()
            ? $this->getOwner()->getId()
            : null;
    }

    /**
     * @return Collection|Inventory[]
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }
    /**
     * @param Collection|Inventory[]
     * @return Organization
     */
    public function setInventories(array $inventories): self
    {
        $this->inventories = $inventories;

        return $this;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setOrganization($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->contains($inventory)) {
            $this->inventories->removeElement($inventory);
        }

        return $this;
    }

    /**
     * @return Collection|OrganizationLocation[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(OrganizationLocation $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setOrganization($this);
        }

        return $this;
    }

    public function removeLocation(OrganizationLocation $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getOrganization() === $this) {
                $location->setOrganization(null);
            }
        }

        return $this;
    }

    public function getAnnualRevenue(): ?string
    {
        return $this->annualRevenue;
    }

    public function setAnnualRevenue(?string $annualRevenue): self
    {
        $this->annualRevenue = $annualRevenue;

        return $this;
    }

    public function getFullTimeHoursPerWeek(): ?int
    {
        return $this->fullTimeHoursPerWeek;
    }

    public function setFullTimeHoursPerWeek(?int $fullTimeHoursPerWeek): self
    {
        $this->fullTimeHoursPerWeek = $fullTimeHoursPerWeek;

        return $this;
    }

    public function getValueProposition(): ?string
    {
        return $this->valueProposition;
    }

    public function setValueProposition(?string $valueProposition): self
    {
        $this->valueProposition = $valueProposition;

        return $this;
    }

    /**
     * Get the value of securityOrganization
     *
     * @return  SecurityOrganization
     */ 
    public function getSecurityOrganization(): SecurityOrganization
    {
        return $this->securityOrganization;
    }

    /**
     * Set the value of securityOrganization
     *
     * @param  SecurityOrganization  $securityOrganization
     *
     * @return  Organization
     */ 
    public function setSecurityOrganization(SecurityOrganization $securityOrganization): self
    {
        $this->securityOrganization = $securityOrganization;

        return $this;
    }

    public function getWebsiteURL(): ?string
    {
        return $this->websiteURL;
    }

    public function setWebsiteURL(?string $websiteURL): self
    {
        $this->websiteURL = $websiteURL;

        return $this;
    }

    public function getMainEmail(): ?string
    {
        return $this->mainEmail;
    }

    public function setMainEmail(?string $mainEmail): self
    {
        $this->mainEmail = $mainEmail;

        return $this;
    }

    public function getMainPhone(): ?string
    {
        return $this->mainPhone;
    }

    public function setMainPhone(?string $mainPhone): self
    {
        $this->mainPhone = $mainPhone;

        return $this;
    }

    public function getBusinessHours(): ?string
    {
        return $this->businessHours;
    }

    public function setBusinessHours(?string $businessHours): self
    {
        $this->businessHours = $businessHours;

        return $this;
    }

    public function getDateFounded(): ?\DateTimeInterface
    {
        return $this->dateFounded;
    }

    public function setDateFounded(?\DateTimeInterface $dateFounded): self
    {
        $this->dateFounded = $dateFounded;

        return $this;
    }

    public function getAdministrator(): ?User
    {
        return $this->administrator;
    }

    public function setAdministrator(?User $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdministratorId()
    {
        return null !== $this->getAdministrator()
            ? $this->getAdministrator()->getId()
            : null;
    }

    
}
