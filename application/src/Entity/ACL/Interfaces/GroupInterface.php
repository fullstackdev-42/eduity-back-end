<?php

namespace App\Entity\ACL\Interfaces;

interface GroupInterface
{
    /**
     * Get the id.
     *
     * @return int
     */
    public function getId();
    
    /**
     * Get the group name.
     *
     * @return string
     */
    public function getName(): ?string;

    /**
     * Set the group name.
     *
     * @param string $name The name
     *
     * @return static
     */
    public function setName(?string $name);
}
