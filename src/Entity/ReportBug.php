<?php

namespace App\Entity;

use App\Repository\ReportBugRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportBugRepository::class)
 */
class ReportBug
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $object_report;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $body_report;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getObjectReport(): ?string
    {
        return $this->object_report;
    }

    public function setObjectReport(string $object_report): self
    {
        $this->object_report = $object_report;

        return $this;
    }

    public function getBodyReport(): ?string
    {
        return $this->body_report;
    }

    public function setBodyReport(string $body_report): self
    {
        $this->body_report = $body_report;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
