<?php

namespace App\Entity;

use App\Repository\NumberSurtaxeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NumberSurtaxeRepository::class)
 */
class NumberSurtaxe
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
    private $pays_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $indicative;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSurtaxed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaysName(): ?string
    {
        return $this->pays_name;
    }

    public function setPaysName(string $pays_name): self
    {
        $this->pays_name = $pays_name;

        return $this;
    }

    public function getIndicative(): ?string
    {
        return $this->indicative;
    }

    public function setIndicative(string $indicative): self
    {
        $this->indicative = $indicative;

        return $this;
    }

    public function getIsSurtaxed(): ?bool
    {
        return $this->isSurtaxed;
    }

    public function setIsSurtaxed(bool $isSurtaxed): self
    {
        $this->isSurtaxed = $isSurtaxed;

        return $this;
    }
}
