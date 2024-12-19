<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\ACL\Interfaces\GroupableInterface;
use App\Entity\ACL\Interfaces\IdentityInterface;
use App\Entity\ACL\Traits\GroupableTrait;
use App\Entity\ACL\Traits\SecurityOrganizationalTrait;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Entity\UserLocation;
use App\Entity\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class User implements UserInterface, GroupableInterface, IdentityInterface
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;
    use GroupableTrait;
    use SecurityOrganizationalTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=180, unique=true)
     * @Gedmo\Versioned
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     mode = "strict"
     * )
     * @Assert\NotBlank(
     *      message = "The email can not be blank"
     * )
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @Assert\NotBlank(
     *      message = "Password can not be blank",
     *      groups={"create"}
     * )
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Password length must be at least {{ limit }} characters long",
     *      groups={"create"}
     * )
     */
    private $plainPassword;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(type="json")
     * @Gedmo\Versioned
     */
    private $roles;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isLocked = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lockExpirationDate;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $loginAttempts = 0;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoginAttempt;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isEmailConfirmed = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailConfirmationCode;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetPasswordCode;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unlockCode;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $resetPasswordCodeExpirationDate;

    /**
     * @var App/Entity/UploadedFile
     * @ORM\OneToOne(targetEntity=UploadedFile::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="avatar_image_id", referencedColumnName="id", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=UserLocation::class, mappedBy="user", cascade={"persist"})
     * @Assert\Valid
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity=UserInvitation::class, mappedBy="user")
     */
    private $userInvitations;

    /**
     * @ORM\OneToMany(targetEntity=UserNotification::class, mappedBy="user", orphanRemoval=true)
     */
    private $userNotifications;

    public function __construct()
    {
        $this->organizations = new ArrayCollection();
        $this->jobmaps = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->userInvitations = new ArrayCollection();
        $this->userNotifications = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): self {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullname(): ?string {
        return $this->firstName .' '. $this->lastName;
    }

    public function getIsLocked(): ?bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): self
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    public function getLockExpirationDate(): ?\DateTimeInterface
    {
        return $this->lockExpirationDate;
    }

    public function setLockExpirationDate(?\DateTimeInterface $lockExpirationDate): self
    {
        $this->lockExpirationDate = $lockExpirationDate;

        return $this;
    }

    public function getLoginAttempts(): ?int
    {
        return $this->loginAttempts;
    }

    public function setLoginAttempts(int $loginAttempts): self
    {
        $this->loginAttempts = $loginAttempts;

        return $this;
    }

    public function getLastLoginAttempt(): ?\DateTimeInterface
    {
        return $this->lastLoginAttempt;
    }

    public function setLastLoginAttempt(\DateTimeInterface $lastLoginAttempt): self
    {
        $this->lastLoginAttempt = $lastLoginAttempt;

        return $this;
    }

    public function incrementLockoutAttempts(string $dateInterval = 'P1D'): self {
        if ($this->getLastLoginAttempt() === null) {
             $this->loginAttempts = 1;
        } else {
            $now = new \DateTime();
            $lastAttempt = $this->getLastLoginAttempt()->add(new \DateInterval($dateInterval));
            if ($lastAttempt > $now) {
                $this->loginAttempts++;
            } else {
                $this->loginAttempts = 1;
            }
        }
        return $this;
    }
    
    public function getIsEmailConfirmed(): ?bool
    {
        return $this->isEmailConfirmed;
    }

    public function setIsEmailConfirmed(bool $isEmailConfirmed): self
    {
        $this->isEmailConfirmed = $isEmailConfirmed;

        return $this;
    }

    public function generateEmailConfirmationCode(): self {
        $this->setEmailConfirmationCode(bin2hex(random_bytes(32)));
        
        return $this;
    }
    
    public function getEmailConfirmationCode(): ?string
    {
        return $this->emailConfirmationCode;
    }

    public function setEmailConfirmationCode(?string $emailConfirmationCode): self
    {
        $this->emailConfirmationCode = $emailConfirmationCode;

        return $this;
    }
    
    public function generateResetPasswordCode(): self {
        $this->setResetPasswordCode(bin2hex(random_bytes(32)));
        
        return $this;
    }

    public function getResetPasswordCode(): ?string
    {
        return $this->resetPasswordCode;
    }

    public function setResetPasswordCode(?string $resetPasswordCode): self
    {
        $this->resetPasswordCode = $resetPasswordCode;

        return $this;
    }
    
    public function generateUnlockCode(): self {
        $this->setUnlockCode(bin2hex(random_bytes(32)));
        
        return $this;
    }

    public function getUnlockCode(): ?string
    {
        return $this->unlockCode;
    }

    public function setUnlockCode(?string $unlockCode): self
    {
        $this->unlockCode = $unlockCode;

        return $this;
    }

    public function getResetPasswordCodeExpirationDate(): ?\DateTimeInterface
    {
        return $this->resetPasswordCodeExpirationDate;
    }

    public function setResetPasswordCodeExpirationDate(?\DateTimeInterface $resetPasswordCodeExpirationDate): self
    {
        $this->resetPasswordCodeExpirationDate = $resetPasswordCodeExpirationDate;

        return $this;
    }

    public function isResetPasswordCodeValid() : bool {
        $now = new \DateTime();
        
        return $this->getResetPasswordCodeExpirationDate() <= $now;
    }

    public function setAvatar(UploadedFile $file) : self {
        $this->avatar = $file;
        return $this;
    }

    public function getAvatar() : ?UploadedFile {
        return $this->avatar;
    }

    /**
     * @return Collection|UserLocation[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(UserLocation $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setUser($this);
        }

        return $this;
    }

    public function removeLocation(UserLocation $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getUser() === $this) {
                $location->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserInvitation[]
     */
    public function getUserInvitations(): Collection
    {
        return $this->userInvitations;
    }

    public function addUserInvitation(UserInvitation $userInvitation): self
    {
        if (!$this->userInvitations->contains($userInvitation)) {
            $this->userInvitations[] = $userInvitation;
            $userInvitation->setUser($this);
        }

        return $this;
    }

    public function removeUserInvitation(UserInvitation $userInvitation): self
    {
        if ($this->userInvitations->contains($userInvitation)) {
            $this->userInvitations->removeElement($userInvitation);
            // set the owning side to null (unless already changed)
            if ($userInvitation->getUser() === $this) {
                $userInvitation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserNotification[]
     */
    public function getUserNotifications(): Collection
    {
        return $this->userNotifications;
    }

    public function addUserNotification(UserNotification $userNotification): self
    {
        if (!$this->userNotifications->contains($userNotification)) {
            $this->userNotifications[] = $userNotification;
            $userNotification->setUser($this);
        }

        return $this;
    }

    public function removeUserNotification(UserNotification $userNotification): self
    {
        if ($this->userNotifications->contains($userNotification)) {
            $this->userNotifications->removeElement($userNotification);
            // set the owning side to null (unless already changed)
            if ($userNotification->getUser() === $this) {
                $userNotification->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of roles
     *
     * @return  string
     */ 
    public function getRoles()
    {
        if (empty($this->roles)) {
            $this->roles = ['ROLE_USER'];
        }
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @param  string  $roles
     *
     * @return  self
     */ 
    public function setRoles(string $roles)
    {
        $this->roles = $roles;

        return $this;
    }
}
