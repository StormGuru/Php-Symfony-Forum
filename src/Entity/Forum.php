<?php

namespace App\Entity;

use App\Repository\ForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumRepository::class)]
class Forum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $keywords;

    #[ORM\Column(type: 'datetime', nullable:  true)]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'parent_id', targetEntity: SubForum::class, orphanRemoval: true)]
    private $subforums;

    public function __construct()
    {
        $this->subforums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, SubForum>
     */
    public function getSubforums(): Collection
    {
        return $this->subforums;
    }

    public function addSubforum(SubForum $subforum): self
    {
        if (!$this->subforums->contains($subforum)) {
            $this->subforums[] = $subforum;
            $subforum->setParentId($this);
        }

        return $this;
    }

    public function removeSubforum(SubForum $subforum): self
    {
        if ($this->subforums->removeElement($subforum)) {
            // set the owning side to null (unless already changed)
            if ($subforum->getParentId() === $this) {
                $subforum->setParentId(null);
            }
        }

        return $this;
    }
}
