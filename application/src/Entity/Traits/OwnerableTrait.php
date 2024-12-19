<?php

namespace App\Entity\Traits;

use App\Entity\Interfaces\OwnerableInterface;
use App\Entity\User;

/**
 * Trait of add dependency entity with an user.
 */
trait OwnerableTrait
{
    /**
     * @var null|User
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    protected $owner;

    /**
     * {@inheritdoc}
     */
    public function setOwner(?User $user): OwnerableInterface
    {
        $this->owner = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerId()
    {
        return null !== $this->getOwner()
            ? $this->getOwner()->getId()
            : null;
    }
}
