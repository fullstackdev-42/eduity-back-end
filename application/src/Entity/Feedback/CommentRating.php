<?php

namespace App\Entity\Feedback;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Table(name="feedback_comment_ratings")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\CommentRatingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CommentRating
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\Comment", inversedBy="commentRatings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

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

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }
}
