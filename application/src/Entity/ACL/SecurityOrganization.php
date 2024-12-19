<?php

namespace App\Entity\ACL;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\ACL\Interfaces\SecurityOrganizationInterface;
use App\Entity\ACL\Traits\SecurityOrganizationTrait;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\ACL\SecurityOrganizationRepository;
use App\Entity\Jobmap\Organization;
use App\Entity\ACL\Traits\OrganizationGroupsTrait;

/**
 * @ORM\Entity(repositoryClass=SecurityOrganizationRepository::class)
 * @ORM\Table(name="security_organization")
 */
class SecurityOrganization implements SecurityOrganizationInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;
    use SecurityOrganizationTrait;

    public static $defaultGroupNames = ['Sponsor', 'Leader', 'Contributor', 'Reviewer', 'Public'];

    /**
     * @var Organization
     * @ORM\OneToOne(targetEntity=Organization::class, cascade={"persist", "remove"}) 
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", nullable=false)   
     */
    private $organization;
    
    public function  __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return Organization
     */ 
    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    /**
     * Set organization
     *
     * @param  Organization  $organization
     *
     * @return  self
     */ 
    public function setOrganization(Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }
}
