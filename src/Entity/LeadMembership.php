<?php

namespace App\Entity;

use App\Repository\LeadMembershipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LeadMembershipRepository::class)
 */
class LeadMembership
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="lead_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $lead_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLeadId(): ?int
    {
        return $this->lead_id;
    }

    public function setLeadId(int $lead_id): self
    {
        $this->lead_id = $lead_id;

        return $this;
    }
}
