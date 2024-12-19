<?php

namespace App\Entity;

use App\Repository\UserNotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EntityUniqueIdTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=UserNotificationRepository::class)
 */
class UserNotification
{
    use EntityUniqueIdTrait;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userNotifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $data;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasRead;


    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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

    /**
     * @return array
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array $data
     *
     * @return UserNotification
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getHasRead(): ?bool
    {
        return $this->hasRead;
    }

    public function setHasRead(bool $hasRead): self
    {
        $this->hasRead = $hasRead;

        return $this;
    }

}
