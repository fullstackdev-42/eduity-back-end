<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\ACL\Interfaces\GroupableInterface;
use App\Entity\ACL\Traits\GroupableTrait;
use App\Entity\Interfaces\OwnerableInterface;
use App\Entity\Jobmap\Element;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Entity\Traits\OwnerableTrait;
use App\Entity\Jobmap\Organization;
use App\Repository\UserInvitationRepository;
use App\Validator\IsOrganizationGroup;
use App\Validator\IsValidUserInvitation;

/**
 * @ORM\Entity(repositoryClass=UserInvitationRepository::class)
 * @IsValidUserInvitation
 * @IsOrganizationGroup
 */
class UserInvitation implements OwnerableInterface, GroupableInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;
    use OwnerableTrait;
    use GroupableTrait;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userInvitations")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     mode = "strict"
     * )
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $acceptCode;

    /**
     * @ORM\ManyToOne(targetEntity=Organization::class)
     */
    private $organization;

    /**
     * @ORM\ManyToOne(targetEntity=Element::class)
     */
    private $element;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $accepted;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function generateAcceptCode(): self {
        $this->setAcceptCode(bin2hex(random_bytes(32)));
        
        return $this;
    }

    public function getAcceptCode(): ?string
    {
        return $this->acceptCode;
    }

    public function setAcceptCode(string $acceptCode): self
    {
        $this->acceptCode = $acceptCode;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function getElement(): ?Element
    {
        return $this->unit;
    }

    public function setElement(?Element $element): self
    {
        $this->element = $element;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }

}
