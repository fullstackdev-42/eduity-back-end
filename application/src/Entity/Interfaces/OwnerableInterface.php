<?php

namespace App\Entity\Interfaces;

use App\Entity\User;

interface OwnerableInterface 
{
    public function setOwner(?User $user): OwnerableInterface;
    public function getOwner(): ?User;
    public function getOwnerId();
}