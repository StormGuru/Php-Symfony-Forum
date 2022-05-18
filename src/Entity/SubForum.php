<?php

namespace App\Entity;

use App\Repository\SubForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubForumRepository::class)]
class SubForum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $subforum;

    #[ORM\ManyToOne(targetEntity: Forum::class, inversedBy: 'subforums')]
    #[ORM\JoinColumn(nullable: false)]
    private $parent_id;

    #[ORM\OneToMany(mappedBy: 'subforum_id', targetEntity: Topic::class, orphanRemoval: true)]
    private $topics;

    public function __construct()
    {
        $this->topics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubforum(): ?string
    {
        return $this->subforum;
    }

    public function setSubforum(string $subforum): self
    {
        $this->subforum = $subforum;

        return $this;
    }

    public function getParentId(): ?Forum
    {
        return $this->parent_id;
    }

    public function setParentId(?Forum $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setSubforumId($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            // set the owning side to null (unless already changed)
            if ($topic->getSubforumId() === $this) {
                $topic->setSubforumId(null);
            }
        }

        return $this;
    }
}
