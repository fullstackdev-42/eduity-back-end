<?php

namespace App\Entity\ACL\Interfaces;

interface GroupableInterface
{
    /**
     * Add a group to the user groups.
     *
     * @param GroupInterface $group
     *
     * @return static
     */
    public function addGroup(GroupInterface $group);

    /**
     * Remove a group from the user groups.
     *
     * @param GroupInterface $group
     *
     * @return static
     */
    public function removeGroup(GroupInterface $group);

    /**
     * Indicates whether the model belongs to the specified group or not.
     *
     * @param string $name The name of the group
     *
     * @return bool
     */
    public function hasGroup(string $name): bool;

    /**
     * Gets the groups granted to the user.
     *
     * @return GroupInterface[]|\Traversable
     */
    public function getGroups();

    /**
     * Gets the name of the groups which includes the user.
     *
     * @return string[]
     */
    public function getGroupNames(): array;

    
}
