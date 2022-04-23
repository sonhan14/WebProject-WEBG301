<?php

namespace App\Entity;

use App\Repository\FeedBackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedBackRepository::class)]
class FeedBack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $feedBack;

    #[ORM\Column(type: 'datetime')]
    private $receivedAt;

    #[ORM\ManyToOne(targetEntity: Teacher::class, inversedBy: 'feedBacks')]
    private $teacher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeedBack(): ?string
    {
        return $this->feedBack;
    }

    public function setFeedBack(string $feedBack): self
    {
        $this->feedBack = $feedBack;

        return $this;
    }

    public function getReceivedAt(): ?\DateTimeInterface
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(\DateTimeInterface $receivedAt): self
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }
}
