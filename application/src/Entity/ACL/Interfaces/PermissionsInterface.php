<?php

namespace App\Entity\ACL\Interfaces;

use Doctrine\Common\Collections\Collection;

interface PermissionsInterface
{
    /**
     * Get the permissions.
     *
     * @return Collection|PermissionInterface[]
     */
    public function getPermissions();

    /**
     * Check if the role has the permission.
     *
     * @param PermissionInterface $permission The permission
     *
     * @return bool
     */
    public function hasPermission(PermissionInterface $permission): bool;

    /**
     * Add the permission.
     *
     * @param PermissionInterface $permission The permission
     *
     * @return static
     */
    public function addPermission(PermissionInterface $permission);

    /**
     * Remove the permission.
     *
     * @param PermissionInterface $permission The permission
     *
     * @return static
     */
    public function removePermission(PermissionInterface $permission);
}
