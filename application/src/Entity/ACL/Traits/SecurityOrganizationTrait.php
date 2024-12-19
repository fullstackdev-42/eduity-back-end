<?php

namespace App\Entity\ACL\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;;

trait SecurityOrganizationTrait
{
    use OrganizationGroupableTrait;

    /**
     * @var null|Collection|User[]
     *
     * @ORM\ManyToMany(
     *  targetEntity=User::class, 
     *  inversedBy="securityOrganizations",
     *  fetch="EXTRA_LAZY",
     *  cascade={"persist"}
     * )
     */
    protected $users;

    /**
     * Get the Users.
     *
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users ?: $this->users = new ArrayCollection();
    }

    /**
     * Check if the role has the user.
     *
     * @param User $user The user
     *
     * @return bool
     */
    public function hasUsers(User $user): bool 
    {
        return $this->getUsers()->contains($user);
    }

    /**
     * Add the user.
     *
     * @param User $user The user
     *
     * @return static
     */
    public function addUser(User $user): self
    {
        if (!$this->getUsers()->contains($user)) {
            $this->getUsers()->add($user);
        }

        return $this;
    }

    /**
     * Remove the user.
     *
     * @param User $user The user
     *
     * @return static
     */
    public function removeUser(User $user): self
    {
        if ($this->getUsers()->contains($user)) {
            $this->getUsers()->removeElement($user);
        }

        return $this;
    }

}
