<?php

namespace App\Entity\ACL;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\ACL\Interfaces\GroupInterface;
use App\Entity\ACL\Interfaces\IdentityInterface;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\ACL\GroupRepository;
use App\Entity\ACL\SecurityOrganization;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(
 *      name="security_groups",
 *      uniqueConstraints={
 *         @ORM\UniqueConstraint(name="uniq_group_organization_name", columns={"organization_id", "name"})
 *     }
 * )
 */
class Group implements GroupInterface, IdentityInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;
    
    /**
     * @ORM\ManyToOne(
     *     targetEntity=SecurityOrganization::class,
     *     fetch="EXTRA_LAZY",
     *     inversedBy="groups",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $organization;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var null|Collection|SecurityOrganization[]
     *
     * @ORM\ManyToMany(
     *      targetEntity=User::class, 
     *      cascade={"persist"}, 
     *      mappedBy="groups"
     * )
     */
    protected $users;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $priority;

    public function  __construct(SecurityOrganization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * Get organization
     *
     * @return SecurityOrganization
     */ 
    public function getOrganization(): SecurityOrganization
    {
        return $this->organization;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

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

    /**
     * Get the value of priority
     *
     * @return  int
     */ 
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * Set the value of priority
     *
     * @param  int  $priority
     *
     * @return  self
     */ 
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
