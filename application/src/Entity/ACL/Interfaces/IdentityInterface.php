<?php

namespace App\Entity\ACL\Interfaces;
use Ramsey\Uuid\UuidInterface;

interface IdentityInterface
{
    public function getId(): int;
    public function getUuid(): ?UuidInterface;
    public function setUuid(UuidInterface $uuid);
}
