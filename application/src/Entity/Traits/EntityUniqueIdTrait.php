<?php
namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

trait EntityUniqueIdTrait {

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     * @ORM\Column(type="uuid", unique=true)
     */
    private $uuid;

    public function getId(): int
    {
        return $this->id;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }

}