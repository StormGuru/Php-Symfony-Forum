<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $commentator;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\Column(type: 'datetime')]
    private $created;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'comments')]
    private $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentator(): ?User
    {
        return $this->commentator;
    }

    public function setCommentator(?User $commentator): self
    {
        $this->commentator = $commentator;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getArticle(): ?Topic
    {
        return $this->article;
    }

    public function setArticle(?Topic $article): self
    {
        $this->article = $article;

        return $this;
    }
}
