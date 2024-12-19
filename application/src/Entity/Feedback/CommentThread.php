<?php

namespace App\Entity\Feedback;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Table(name="feedback_comment_threads")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\CommentThreadRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class CommentThread
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\Discussion", inversedBy="commentThreads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discussion;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Versioned
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\Comment", mappedBy="commentThread")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCommentThread($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getCommentThread() === $this) {
                $comment->setCommentThread(null);
            }
        }

        return $this;
    }
}
