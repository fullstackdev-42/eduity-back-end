<?php


namespace App\Entity\ACL\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ACL\Interfaces\GroupInterface;
use App\Entity\ACL\Group;

trait OrganizationGroupableTrait
{
    /**
     * @var null|Collection|GroupInterface[]
     *
     * @ORM\OneToMany(
     *     targetEntity=Group::class,
     *     mappedBy="organization",
     *     fetch="EXTRA_LAZY",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    protected $groups;

    /**
     * {@inheritdoc}
     */
    public function getGroups(): Collection
    {
        return $this->groups ?: $this->groups = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupNames(): array
    {
        $names = [];
        foreach ($this->getGroups() as $group) {
            $names[] = $group->getName();
        }

        return $names;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroup(string $group): bool
    {
        return \in_array($group, $this->getGroupNames(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(GroupInterface $group): self
    {
        if (!$this->getGroups()->contains($group)) {
            $this->getGroups()->add($group);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeGroup(GroupInterface $group): self
    {
        if ($this->getGroups()->contains($group)) {
            $this->getGroups()->removeElement($group);
        }

        return $this;
    }

}
