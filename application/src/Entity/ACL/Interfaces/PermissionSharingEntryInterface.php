<?php

namespace App\Entity\ACL\Interfaces;

use Doctrine\Common\Collections\Collection;

interface PermissionSharingEntryInterface
{
    /**
     * @return Collection|SharingInterface[]
     */
    public function getSharingEntries();
}
