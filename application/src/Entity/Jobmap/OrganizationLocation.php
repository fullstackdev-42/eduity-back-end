<?php

namespace App\Entity\Jobmap;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Entity\Traits\LocationTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Jobmap\OrganizationLocationRepository")
 * @ORM\Table(name="jobmap_organization_locations")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class OrganizationLocation
{
    use EntityUniqueIdTrait;
    use LocationTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jobmap\Organization", inversedBy="locations")
     */
    private $organization;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Gedmo\Versioned
     * @Assert\Time
     */
    private $businessOpenHours;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @Gedmo\Versioned
     * @Assert\Time
     */
    private $businessCloseHours;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     * @Assert\Email
     */
    private $email;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getBusinessOpenHours(): ?\DateTimeInterface
    {
        return $this->businessOpenHours;
    }

    public function setBusinessOpenHours(?\DateTimeInterface $businessOpenHours): self
    {
        $this->businessOpenHours = $businessOpenHours;

        return $this;
    }

    public function getBusinessCloseHours(): ?\DateTimeInterface
    {
        return $this->businessCloseHours;
    }

    public function setBusinessCloseHours(?\DateTimeInterface $businessCloseHours): self
    {
        $this->businessCloseHours = $businessCloseHours;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
