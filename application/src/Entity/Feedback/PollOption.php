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
 * @ORM\Table(name="feedback_poll_options")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\PollOptionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class PollOption
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\Poll", inversedBy="pollOptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poll;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Versioned
     */
    private $value;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Versioned
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Gedmo\Versioned
     */
    private $order;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\PollRating", mappedBy="pollOption")
     */
    private $pollRatings;

    public function __construct()
    {
        $this->pollRatings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function setPoll(?Poll $poll): self
    {
        $this->poll = $poll;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return Collection|PollRating[]
     */
    public function getPollRatings(): Collection
    {
        return $this->pollRatings;
    }

    public function addPollRating(PollRating $pollRating): self
    {
        if (!$this->pollRatings->contains($pollRating)) {
            $this->pollRatings[] = $pollRating;
            $pollRating->setPollOption($this);
        }

        return $this;
    }

    public function removePollRating(PollRating $pollRating): self
    {
        if ($this->pollRatings->contains($pollRating)) {
            $this->pollRatings->removeElement($pollRating);
            // set the owning side to null (unless already changed)
            if ($pollRating->getPollOption() === $this) {
                $pollRating->setPollOption(null);
            }
        }

        return $this;
    }
}
