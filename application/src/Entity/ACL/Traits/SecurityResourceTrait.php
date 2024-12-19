<?php

namespace App\Entity\ACL\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SecurityResourceTrait
{
    use PermissionsTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $subjectClass;

    /**
     * @var string
     *
     * @ORM\Column(type="integer")
     */
    protected $subjectId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $identityClass;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $identityId;

    /**
     * @var null|bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $allowance;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $priority;

    public function setSubjectClass(string $class): self
    {
        $this->subjectClass = $class;

        return $this;
    }

    public function getSubjectClass(): string
    {
        return $this->subjectClass;
    }

    public function setSubjectId(int $id): self
    {
        $this->subjectId = $id;

        return $this;
    }

    public function getSubjectId(): int
    {
        return $this->subjectId;
    }

    public function setIdentityClass(string $class): self
    {
        $this->identityClass = $class;

        return $this;
    }

    public function getIdentityClass(): string
    {
        return $this->identityClass;
    }

    public function setIdentityId(int $id): self
    {
        $this->identityId = $id;

        return $this;
    }

    public function getIdentityId(): int
    {
        return $this->identityId;
    }

    /**
     * Get the value of allowance
     *
     * @return  null|bool
     */ 
    public function getAllowance(): ?bool
    {
        return $this->allowance;
    }

    /**
     * Set the value of allowance
     *
     * @param  null|bool  $allowance
     *
     * @return  self
     */ 
    public function setAllowance(?bool $allowance): self
    {
        $this->allowance = $allowance;

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
