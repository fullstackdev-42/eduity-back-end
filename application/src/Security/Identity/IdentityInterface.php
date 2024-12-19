<?php

namespace App\Security\Identity;

interface IdentityInterface
{
    public function getType(): string;

    public function getIdentifier(): string;

    public function equals(IdentityInterface $identity): bool;
}