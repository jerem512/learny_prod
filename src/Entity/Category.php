<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $lead_category;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $closer_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLeadCategory(): ?string
    {
        return $this->lead_category;
    }

    public function setLeadCategory(string $lead_category): self
    {
        $this->lead_category = $lead_category;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCloserId(): ?int
    {
        return $this->closer_id;
    }

    public function setCloserId(int $closer_id): self
    {
        $this->closer_id = $closer_id;

        return $this;
    }
}
