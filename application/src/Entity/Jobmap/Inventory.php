<?php

namespace App\Entity\Jobmap;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\Jobmap\InventoryRepository;
use App\Entity\Jobmap\Organization;
use App\Entity\Jobmap\Node;
/**
 * @ORM\Table(name="jobmap_organization_inventories")
 * @ORM\Entity(repositoryClass=InventoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Inventory
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class, inversedBy="inventories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organization;

    /**
     * @ORM\OneToMany(targetEntity=Node::class, mappedBy="inventory", cascade={"persist"})
     */
    private $nodes;

    public function __construct()
    {
        $this->nodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Organization
     */
    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return Collection|Node[]
     */
    public function getNodes(): Collection
    {
        return $this->nodes;
    }

    public function setNodes($nodes): self 
    {   
        $this->nodes = $nodes;

        return $this;
    }

    public function addNode(Node $node): self
    {
        if (!$this->nodes->contains($node)) {
            $this->nodes[] = $node;
            $node->setInventory($this);
        }

        return $this;
    }

    public function removeNode(Node $node): self
    {
        if ($this->nodes->contains($node)) {
            $this->nodes->removeElement($node);
            // set the owning side to null (unless already changed)
            if ($node->getInventory() === $this) {
                $node->setInventory(null);
            }
        }

        return $this;
    }

}
