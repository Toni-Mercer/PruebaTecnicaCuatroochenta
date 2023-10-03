<?php

namespace App\Entity;

use App\Repository\ReadingLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadingLogRepository::class)]
class ReadingLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(name: 'user_id')]
    private ?int $userId = null;

    #[ORM\OneToOne(targetEntity: 'App\Entity\Reading')]
    private ?Reading $reading = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getReading(): ?Reading
    {
        return $this->reading;
    }

    public function setReading(?Reading $reading): self
    {
        $this->reading = $reading;
        return $this;
    }
}
