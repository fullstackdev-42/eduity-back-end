<?php

namespace App\Entity\Feedback;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Table(name="feedback_comments")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Comment
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\CommentThread", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentThread;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\Comment", inversedBy="comments")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\Comment", mappedBy="parent")
     */
    private $comments;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Versioned
     */
    private $message;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\CommentRating", mappedBy="comment")
     */
    private $commentRatings;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->commentRatings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentThread(): ?CommentThread
    {
        return $this->commentThread;
    }

    public function setCommentThread(?CommentThread $commentThread): self
    {
        $this->commentThread = $commentThread;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(self $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setParent($this);
        }

        return $this;
    }

    public function removeComment(self $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getParent() === $this) {
                $comment->setParent(null);
            }
        }

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Collection|CommentRating[]
     */
    public function getCommentRatings(): Collection
    {
        return $this->commentRatings;
    }

    public function addCommentRating(CommentRating $commentRating): self
    {
        if (!$this->commentRatings->contains($commentRating)) {
            $this->commentRatings[] = $commentRating;
            $commentRating->setComment($this);
        }

        return $this;
    }

    public function removeCommentRating(CommentRating $commentRating): self
    {
        if ($this->commentRatings->contains($commentRating)) {
            $this->commentRatings->removeElement($commentRating);
            // set the owning side to null (unless already changed)
            if ($commentRating->getComment() === $this) {
                $commentRating->setComment(null);
            }
        }

        return $this;
    }

    public function getAuthor(): User {
        return $this->getCreatedBy();
    }
}
