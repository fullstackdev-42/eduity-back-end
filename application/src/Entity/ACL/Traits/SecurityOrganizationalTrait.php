<?php

namespace App\Entity\ACL\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ACL\Interfaces\SecurityOrganizationInterface;
use App\Entity\ACL\SecurityOrganization;

trait SecurityOrganizationalTrait
{
    /**
     * @var null|Collection|SecurityOrganization[]
     *
     * @ORM\ManyToMany(
     *     targetEntity=SecurityOrganization::class, 
     *     mappedBy="users",
     *     fetch="EXTRA_LAZY",
     *     cascade={"persist"}
     * )
     */
    protected $securityOrganizations;

    /**
     * Get the value of securityOrganizations
     *
     * @return  null|Collection|SecurityOrganization[]
     */ 
    public function getSecurityOrganizations()
    {
        return $this->securityOrganizations;
    }

    public function addSecurityOrganization(SecurityOrganizationInterface $securityOrganization): self
    {
        if (!$this->getSecurityOrganizations()->contains($securityOrganization)) {
            $this->getSecurityOrganizations()->add($securityOrganization);
        }

        return $this;
    }

    public function removeSecurityOrganization(SecurityOrganizationInterface $SecurityOrganization): self
    {
        if ($this->getSecurityOrganizations()->contains($SecurityOrganization)) {
            $this->getSecurityOrganizations()->removeElement($SecurityOrganization);
        }

        return $this;
    }
}