<?php

namespace App\Entity;

use App\Repository\ClosingRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClosingRateRepository::class)
 * @ORM\Table(name="`closing_rate`")
 */
class ClosingRate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="date")
     */
    public $date;

    /**
     * @ORM\Column(type="integer")
     */
    public $fup;

    /**
     * @ORM\Column(type="integer")
     */
    public $shofup;

    /**
     * @ORM\Column(type="integer")
     */
    public $back;

    /**
     * @ORM\Column(type="integer")
     */
    public $closefup;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads_valid;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads_contact;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads_offer;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads_fup;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads_close;

    /**
     * @ORM\Column(type="integer")
     */
    public $leads_confirm;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="closingRates_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFup(): ?int
    {
        return $this->fup;
    }

    public function setFup(int $fup): self
    {
        $this->fup = $fup;

        return $this;
    }

    public function getShofup(): ?int
    {
        return $this->shofup;
    }

    public function setShofup(int $shofup): self
    {
        $this->shofup = $shofup;

        return $this;
    }

    public function getBack(): ?int
    {
        return $this->back;
    }

    public function setBack(int $back): self
    {
        $this->back = $back;

        return $this;
    }

    public function getClosefup(): ?int
    {
        return $this->closefup;
    }

    public function setClosefup(int $closefup): self
    {
        $this->closefup = $closefup;

        return $this;
    }

    public function getLeads(): ?int
    {
        return $this->leads;
    }

    public function setLeads(int $leads): self
    {
        $this->leads = $leads;

        return $this;
    }

    public function getLeadsValid(): ?int
    {
        return $this->leads_valid;
    }

    public function setLeadsValid(int $leads_valid): self
    {
        $this->leads_valid = $leads_valid;

        return $this;
    }

    public function getLeadsContact(): ?int
    {
        return $this->leads_contact;
    }

    public function setLeadsContact(int $leads_contact): self
    {
        $this->leads_contact = $leads_contact;

        return $this;
    }

    public function getLeadsOffer(): ?int
    {
        return $this->leads_offer;
    }

    public function setLeadsOffer(int $leads_offer): self
    {
        $this->leads_offer = $leads_offer;

        return $this;
    }

    public function getLeadsFup(): ?int
    {
        return $this->leads_fup;
    }

    public function setLeadsFup(int $leads_fup): self
    {
        $this->leads_fup = $leads_fup;

        return $this;
    }

    public function getLeadsClose(): ?int
    {
        return $this->leads_close;
    }

    public function setLeadsClose(int $leads_close): self
    {
        $this->leads_close = $leads_close;

        return $this;
    }

    public function getLeadsConfirm(): ?int
    {
        return $this->leads_confirm;
    }

    public function setLeadsConfirm(int $leads_confirm): self
    {
        $this->leads_confirm = $leads_confirm;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

}
