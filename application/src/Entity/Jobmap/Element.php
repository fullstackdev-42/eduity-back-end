<?php

namespace App\Entity\Jobmap;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Repository\Jobmap\ElementRepository;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Entity\Jobmap\Node;
use App\Entity\Jobmap\Attribute;

/**
 * @ORM\Table(name="jobmap_organization_inventory_node_elements")
 * @ORM\Entity(repositoryClass=ElementRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Element
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\Versioned
     */
    private $revisionId;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Node::class, inversedBy="elements")
     */
    private $node;

    /**
     * @ORM\OneToMany(targetEntity=Attribute::class, mappedBy="element", cascade={"persist"})
     */
    private $attributes;

    /**
     * @ORM\ManyToOne(targetEntity=Element::class, inversedBy="subElements")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Element::class, mappedBy="parent", cascade={"persist"})
     */
    private $subElements;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned
     */
    private $endDate;

    public function __construct()
    {
        $this->nodes = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->subElements = new ArrayCollection();
        $this->revisionId = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNode(): Node
    {
        return $this->node;
    }

    public function setNode(Node $node): self
    {
        $this->node = $node;
        return $this;
    }

    /**
     * @return Collection|Attribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function setAttributes($attributes): self
    {
        if ($attributes !== null && is_array($attributes)) {
            $attributes = new ArrayCollection($attributes);
        }

        $this->attributes = $attributes;

        return $this;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setElement($this);
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRevisionId(): ?int
    {
        return $this->revisionId;
    }

    public function setRevisionId(int $revisionId): self
    {
        $this->revisionId = $revisionId;

        return $this;
    }

    public function getParent(): ?Element
    {
        return $this->parent;
    }

    public function setParent(?Element $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getSubElements(): ?Collection
    {
        return new ArrayCollection();//$this->subElements;
    }

    public function setSubElements($subElements = null): self
    {
        if ($subElements !== null && is_array($subElements)) {
            $subElements = new ArrayCollection($subElements);
        }
        $this->subElements = $subElements;

        return $this;
    }
}
