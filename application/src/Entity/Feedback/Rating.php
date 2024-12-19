<?php

namespace App\Entity\Feedback;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;
use App\Repository\Feedback\RatingRepository;

/**
 * @ORM\Table(name="feedback_ratings")
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Rating
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\OneToOne(targetEntity=Discussion::class, mappedBy="approval", cascade={"persist", "remove"})
     */
    private $discussion;

    /**
     * @ORM\Column(type="smallint")
     */
    private $score;

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

        // set (or unset) the owning side of the relation if necessary
        $newRating = null === $discussion ? null : $this;
        if ($discussion->getRating() !== $newRating) {
            $discussion->setRating($newRating);
        }

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
