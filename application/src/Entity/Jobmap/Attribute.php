<?php

namespace App\Entity\Jobmap;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\Jobmap\AttributeRepository;
use App\Entity\Jobmap\Element;;
/**
 * @ORM\Table(name="jobmap_organization_inventory_node_element_attributes")
 * @ORM\Entity(repositoryClass=AttributeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Attribute
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
    private $name;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Gedmo\Versioned
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Element::class, inversedBy="attributes")
     * @Gedmo\Versioned
     */
    private $element;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $originatorType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $originatorId;

    public function __construct()
    {
        $this->revisionId = 1;
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getElement(): ?Element
    {
        return $this->element;
    }

    public function setElement(?Element $element): self
    {
        $this->element = $element;

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

    public function getOriginatorType(): ?string
    {
        return $this->originatorType;
    }

    public function setOriginatorType(?string $originatorType): self
    {
        $this->originatorType = $originatorType;

        return $this;
    }

    public function getOriginatorId(): ?string
    {
        return $this->originatorId;
    }

    public function setOriginatorId(?string $originatorId): self
    {
        $this->originatorId = $originatorId;

        return $this;
    }

}
