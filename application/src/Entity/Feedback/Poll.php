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
 * @ORM\Table(name="feedback_polls")
 * @ORM\Entity(repositoryClass="App\Repository\Feedback\PollRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Loggable
 */
class Poll
{
    use EntityUniqueIdTrait;
    use BlameableEntity;
    use TimestampableEntity;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feedback\Discussion", inversedBy="polls")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback\PollOption", mappedBy="poll")
     */
    private $pollOptions;

    public function __construct()
    {
        $this->pollOptions = new ArrayCollection();
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
     * @return Collection|PollOption[]
     */
    public function getPollOptions(): Collection
    {
        return $this->pollOptions;
    }

    public function addPollOption(PollOption $pollOption): self
    {
        if (!$this->pollOptions->contains($pollOption)) {
            $this->pollOptions[] = $pollOption;
            $pollOption->setPoll($this);
        }

        return $this;
    }

    public function removePollOption(PollOption $pollOption): self
    {
        if ($this->pollOptions->contains($pollOption)) {
            $this->pollOptions->removeElement($pollOption);
            // set the owning side to null (unless already changed)
            if ($pollOption->getPoll() === $this) {
                $pollOption->setPoll(null);
            }
        }

        return $this;
    }

}
