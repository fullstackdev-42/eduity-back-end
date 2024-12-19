<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Entity\Traits\LocationTrait;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserLocationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class UserLocation
{
    use EntityUniqueIdTrait;
    use LocationTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="locations")
     */
    private $user;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
