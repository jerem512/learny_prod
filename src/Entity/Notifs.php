<?php

namespace App\Entity;

use App\Repository\NotifsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotifsRepository::class)
 */
class Notifs
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
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_from;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_to;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lead_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_valited;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUserFrom(): ?string
    {
        return $this->user_from;
    }

    public function setUserFrom(string $user_from): self
    {
        $this->user_from = $user_from;

        return $this;
    }

    public function getUserTo(): ?string
    {
        return $this->user_to;
    }

    public function setUserTo(string $user_to): self
    {
        $this->user_to = $user_to;

        return $this;
    }

    public function getLeadId(): ?string
    {
        return $this->lead_id;
    }

    public function setLeadId(string $lead_id): self
    {
        $this->lead_id = $lead_id;

        return $this;
    }

    public function getIsValited(): ?bool
    {
        return $this->is_valited;
    }

    public function setIsValited(bool $is_valited): self
    {
        $this->is_valited = $is_valited;

        return $this;
    }
}
