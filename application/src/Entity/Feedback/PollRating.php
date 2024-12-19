<?php

namespace App\Entity\Feedback;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Traits\EntityUniqueIdTrait;

/**
 * @ORM\Table(name="feedback_poll_ratings")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\PollRatingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PollRating
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\PollOption", inversedBy="pollRatings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pollOption;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPollOption(): ?PollOption
    {
        return $this->pollOption;
    }

    public function setPollOption(?PollOption $pollOption): self
    {
        $this->pollOption = $pollOption;

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
