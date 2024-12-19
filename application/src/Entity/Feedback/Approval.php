<?php

namespace App\Entity\Feedback;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\Feedback\ApprovalRepository;

/**
 * @ORM\Table(name="feedback_approvals")
 * @ORM\Entity(repositoryClass=ApprovalRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Approval
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\OneToOne(targetEntity=Discussion::class, mappedBy="approval", cascade={"persist", "remove"})
     */
    private $discussion;

    /**
     * @ORM\Column(type="boolean")
     * @Gedmo\Versioned
     */
    private $isApproved;

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

        // set (or unset) the owning side of the relation if necessary
        $newApproval = null === $discussion ? null : $this;
        if ($discussion->getApproval() !== $newApproval) {
            $discussion->setApproval($newApproval);
        }

        return $this;
    }

    public function getIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    
}
