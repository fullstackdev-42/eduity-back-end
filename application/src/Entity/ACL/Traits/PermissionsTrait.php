<?php

namespace App\Entity\ACL\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ACL\Interfaces\PermissionInterface;
use App\Entity\ACL\Permission;

trait PermissionsTrait
{
    /**
     * @var null|Collection|PermissionInterface[]
     *
     * @ORM\ManyToMany(
     *     targetEntity=Permission::class,
     *     cascade={"persist"}
     * )
     * @ORM\JoinTable(
     *     name="security_permissions_associations",
     *     joinColumns={
     *         @ORM\JoinColumn(onDelete="CASCADE")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(onDelete="CASCADE", name="permission_id")
     *     }
     * )
     */
    protected $permissions;

    public function getPermissions(): Collection
    {
        return $this->permissions ?: $this->permissions = new ArrayCollection();
    }

    public function hasPermission(PermissionInterface $permission): bool
    {
        return $this->getPermissions()->contains($permission);
    }

    public function addPermission(PermissionInterface $permission): self
    {
        if (!$this->getPermissions()->contains($permission)) {
            $this->getPermissions()->add($permission);
        }

        return $this;
    }

    public function removePermission(PermissionInterface $permission): self
    {
        if ($this->getPermissions()->contains($permission)) {
            $this->getPermissions()->removeElement($permission);
        }

        return $this;
    }
}
