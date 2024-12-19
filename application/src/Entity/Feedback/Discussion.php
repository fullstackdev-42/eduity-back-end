<?php

namespace App\Entity\Feedback;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Table(name="feedback_discussions")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\DiscussionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Discussion
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subjectClassname;

    /**
     * @ORM\Column(type="integer")
     */
    private $subjectId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\Poll", mappedBy="discussion")
     */
    private $polls;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\CommentThread", mappedBy="discussion")
     */
    private $commentThreads;

    /**
     * @ORM\OneToOne(targetEntity=Rating::class, cascade={"persist", "remove"})
     */
    private $rating;

    /**
     * @ORM\OneToOne(targetEntity=Approval::class, inversedBy="discussion", cascade={"persist", "remove"})
     */
    private $approval;

    public function __construct()
    {
        $this->polls = new ArrayCollection();
        $this->commentThreads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjectClassname(): ?string
    {
        return $this->subjectClassname;
    }

    public function setSubjectClassname(string $subjectClassname): self
    {
        $this->subjectClassname = $subjectClassname;

        return $this;
    }

    public function getSubjectId(): ?int
    {
        return $this->subjectId;
    }

    public function setSubjectId(int $subjectId): self
    {
        $this->subjectId = $subjectId;

        return $this;
    }

    /**
     * @return Collection|Poll[]
     */
    public function getPolls(): Collection
    {
        return $this->polls;
    }

    public function addPoll(Poll $poll): self
    {
        if (!$this->polls->contains($poll)) {
            $this->polls[] = $poll;
            $poll->setDiscussion($this);
        }

        return $this;
    }

    public function removePoll(Poll $poll): self
    {
        if ($this->polls->contains($poll)) {
            $this->polls->removeElement($poll);
            // set the owning side to null (unless already changed)
            if ($poll->getDiscussion() === $this) {
                $poll->setDiscussion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentThread[]
     */
    public function getCommentThreads(): Collection
    {
        return $this->commentThreads;
    }

    public function addCommentThread(CommentThread $commentThread): self
    {
        if (!$this->commentThreads->contains($commentThread)) {
            $this->commentThreads[] = $commentThread;
            $commentThread->setDiscussion($this);
        }

        return $this;
    }

    public function removeCommentThread(CommentThread $commentThread): self
    {
        if ($this->commentThreads->contains($commentThread)) {
            $this->commentThreads->removeElement($commentThread);
            // set the owning side to null (unless already changed)
            if ($commentThread->getDiscussion() === $this) {
                $commentThread->setDiscussion(null);
            }
        }

        return $this;
    }

    public function getRating(): ?Rating
    {
        return $this->rating;
    }

    public function setRating(?Rating $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getApproval(): ?Approval
    {
        return $this->approval;
    }

    public function setApproval(?Approval $approval): self
    {
        $this->approval = $approval;

        return $this;
    }
}
