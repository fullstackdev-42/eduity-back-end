<?php

namespace App\Entity\ACL;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\ACL\Interfaces\PermissionInterface;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\ACL\PermissionRepository;

/**
 * @ORM\Entity(repositoryClass=PermissionRepository::class)
 * @ORM\Table(
 *     name="security_permissions",
 *     indexes={
 *         @ORM\Index(name="idx_permission_operation", columns={"operation"}),
 *         @ORM\Index(name="idx_permission_class", columns={"class"}),
 *         @ORM\Index(name="idx_permission_field", columns={"field"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="uniq_permission", columns={"operation", "class", "field"})
 *     }
 * )
 */
class Permission implements PermissionInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string[]
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $contexts = [];

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $class;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $field;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $operation;

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setOperation(string $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setContexts(?array $contexts): self
    {
        $this->contexts = $contexts;

        return $this;
    }

    public function getContexts(): ?array
    {
        return $this->contexts;
    }

    public function setClass(?string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setField(?string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

}
