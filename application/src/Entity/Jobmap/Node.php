<?php

namespace App\Entity\Jobmap;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Table(name="jobmap_organization_inventory_nodes")
 * @ORM\Entity(repositoryClass="App\Repository\Jobmap\NodeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Tree(type="nested")
 * @Gedmo\Loggable
 */
class Node
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
     * @ORM\ManyToOne(targetEntity=Inventory::class, inversedBy="nodes")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Versioned
     */
    private $inventory;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     * @Gedmo\Versioned
     */
    private $lft;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     * @Gedmo\Versioned
     */
    private $rgt;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     * @Gedmo\Versioned
     */
    private $lvl;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity=Node::class)
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     * @Gedmo\Versioned
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity=Node::class, inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * @Gedmo\Versioned
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Node::class, mappedBy="parent", cascade={"persist"})
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

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

    /**
     * @ORM\OneToMany(targetEntity=Element::class, mappedBy="node", cascade={"persist"})
     */
    private $elements;

    public function __construct()
    {
        $this->nodes = new ArrayCollection();
        $this->elements = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->revisionId = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        if ($this->inventory !== $inventory)
        {
            $this->inventory = $inventory;

            /** @var Node $node */
            foreach ($this->getChildren() as $node) {
                $node->setInventory($inventory);
            }
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

    /**
     * @return Collection|Element[]
     */
    public function getElements(): ?Collection
    {
        return $this->elements;
    }

    public function setElements($elements = null): self
    {
        $this->elements = $elements;

        return $this;
    }


    public function addElement(Element $unit): self
    {
        if (!$this->elements->contains($unit)) {
            $this->elements[] = $unit;
        }

        return $this;
    }

    public function removeElement(Element $unit): self
    {
        if ($this->elements->contains($unit)) {
            $this->elements->removeElement($unit);
        }

        return $this;
    }

    public function getLft(): ?int
    {
        return $this->lft;
    }

    public function setLft(int $lft): self
    {
        $this->lft = $lft;

        return $this;
    }

    public function getRgt(): ?int
    {
        return $this->rgt;
    }

    public function setRgt(int $rgt): self
    {
        $this->rgt = $rgt;

        return $this;
    }

    public function getLvl(): ?int
    {
        return $this->lvl;
    }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;

        return $this;
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setRoot(?self $root): self
    {
        $this->root = $root;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        if ($parent !== null) {
            $this->setInventory($parent->getInventory());
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    public function setChildren($children = null): self
    {
        $this->children = $children;

        return $this;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

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
}
