<?php

namespace App\Entity\ACL\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ACL\Interfaces\GroupInterface;
use App\Entity\ACL\Group;

trait GroupableTrait
{
    /**
     * @var Collection|GroupInterface[]
     *
     * @ORM\ManyToMany(
     *      targetEntity=Group::class, 
     *      orphanRemoval=true,
     *      cascade={"persist"})
     * @ORM\JoinTable(
     *     joinColumns={
     *         @ORM\JoinColumn(onDelete="CASCADE")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(onDelete="CASCADE", name="group_id")
     *     }
     * )
     */
    protected $groups;

    public function getGroups(): Collection
    {
        return $this->groups ?: $this->groups = new ArrayCollection();
    }

    public function getGroupNames(): array
    {
        $names = [];

        foreach ($this->getGroups() as $group) {
            $names[] = $group->getName();
        }

        return $names;
    }

    public function hasGroup(string $name): bool
    {
        return \in_array($name, $this->getGroupNames(), true);
    }

    public function addGroup(GroupInterface $group): self
    {
        if (!$this->getGroups()->contains($group)) {
            $this->getGroups()->add($group);
        }

        return $this;
    }

    public function removeGroup(GroupInterface $group): self
    {
        if ($this->getGroups()->contains($group)) {
            $this->getGroups()->removeElement($group);
        }

        return $this;
    }
}