<?php

namespace App\Entity\ACL\Interfaces;

use Doctrine\Common\Collections\Collection;
use App\Entity\User;

interface SecurityOrganizationInterface
{
    /**
     * Get the Users.
     *
     * @return Collection|User[]
     */
    public function getUsers();

    /**
     * Check if the role has the user.
     *
     * @param User $user The user
     *
     * @return bool
     */
    public function hasUsers(User $user): bool;

    /**
     * Add the user.
     *
     * @param User $user The user
     *
     * @return static
     */
    public function addUser(User $user);

    /**
     * Remove the user.
     *
     * @param User $user The user
     *
     * @return static
     */
    public function removeUser(User $user);

}
