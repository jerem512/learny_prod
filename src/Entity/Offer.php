<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $price_ht;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nb_monthly_payment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceHt(): ?string
    {
        return $this->price_ht;
    }

    public function setPriceHt(string $price_ht): self
    {
        $this->price_ht = $price_ht;

        return $this;
    }

    public function getCommission(): ?string
    {
        return $this->commission;
    }

    public function setCommission(string $commission): self
    {
        $this->commission = $commission;

        return $this;
    }

    public function getNbMonthlyPayment(): ?string
    {
        return $this->nb_monthly_payment;
    }

    public function setNbMonthlyPayment(string $nb_monthly_payment): self
    {
        $this->nb_monthly_payment = $nb_monthly_payment;

        return $this;
    }

    public function getFrontName(): ?string
    {
        return $this->front_name;
    }

    public function setFrontName(string $front_name): self
    {
        $this->front_name = $front_name;

        return $this;
    }
}
