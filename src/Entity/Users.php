<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $calendly_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ringover_phone_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ringover_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $learnybox_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uuid_calendly;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact_number;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $client_id_google;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refresh_token_google;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $client_secret_google;

    /**
     * @ORM\OneToMany(targetEntity=ModelMail::class, mappedBy="model_mail", orphanRemoval=true)
     */
    private $modelMails;

    /**
     * @ORM\OneToMany(targetEntity=LeadMembership::class, mappedBy="user", orphanRemoval=true)
     */
    private $lead_id;

    /**
     * @ORM\OneToMany(targetEntity=ClosingRate::class, mappedBy="user_id", orphanRemoval="true")
     */
    private $closingRates_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $api_key_learnybox;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subdomain_learnybox;

    public function __construct()
    {
        $this->modelMails = new ArrayCollection();
        $this->lead_id = new ArrayCollection();
        $this->closingRates_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

     /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|ClosingRate[]
     */
    public function getClosingRatesId(): Collection
    {
        return $this->closingRates_id;
    }

    public function addClosingRatesId(ClosingRate $closingRatesId): self
    {
        if (!$this->closingRates_id->contains($closingRatesId)) {
            $this->closingRates_id[] = $closingRatesId;
            $closingRatesId->setUserId($this);
        }

        return $this;
    }

    public function removeClosingRatesId(ClosingRate $closingRatesId): self
    {
        if ($this->closingRates_id->removeElement($closingRatesId)) {
            // set the owning side to null (unless already changed)
            if ($closingRatesId->getUserId() === $this) {
                $closingRatesId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function setBirthdate(?string $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCalendlyToken(): ?string
    {
        return $this->calendly_token;
    }

    public function setCalendlyToken(?string $calendly_token): self
    {
        $this->calendly_token = $calendly_token;

        return $this;
    }

    public function getRingoverPhoneNumber(): ?string
    {
        return $this->ringover_phone_number;
    }

    public function setRingoverPhoneNumber(?string $ringover_phone_number): self
    {
        $this->ringover_phone_number = $ringover_phone_number;

        return $this;
    }

    public function getRingoverToken(): ?string
    {
        return $this->ringover_token;
    }

    public function setRingoverToken(?string $ringover_token): self
    {
        $this->ringover_token = $ringover_token;

        return $this;
    }

    public function getLearnyboxToken(): ?string
    {
        return $this->learnybox_token;
    }

    public function setLearnyboxToken(?string $learnybox_token): self
    {
        $this->learnybox_token = $learnybox_token;

        return $this;
    }

    public function getUuidCalendly(): ?string
    {
        return $this->uuid_calendly;
    }

    public function setUuidCalendly(?string $uuid_calendly): self
    {
        $this->uuid_calendly = $uuid_calendly;

        return $this;
    }

    public function getContactNumber(): ?string
    {
        return $this->contact_number;
    }

    public function setContactNumber(?string $contact_number): self
    {
        $this->contact_number = $contact_number;

        return $this;
    }

    public function getImages(): ?Images
    {
        return $this->images;
    }

    public function setImages(Images $images): self
    {
        // set the owning side of the relation if necessary
        if ($images->getUser() !== $this) {
            $images->setUser($this);
        }

        $this->images = $images;

        return $this;
    }

    public function getClientIdGoogle(): ?string
    {
        return $this->client_id_google;
    }

    public function setClientIdGoogle(?string $client_id_google): self
    {
        $this->client_id_google = $client_id_google;

        return $this;
    }

    public function getRefreshTokenGoogle(): ?string
    {
        return $this->refresh_token_google;
    }

    public function setRefreshTokenGoogle(?string $refresh_token_google): self
    {
        $this->refresh_token_google = $refresh_token_google;

        return $this;
    }

    public function getClientSecretGoogle(): ?string
    {
        return $this->client_secret_google;
    }

    public function setClientSecretGoogle(?string $client_secret_google): self
    {
        $this->client_secret_google = $client_secret_google;

        return $this;
    }

    /**
     * @return Collection|ModelMail[]
     */
    public function getModelMails(): Collection
    {
        return $this->modelMails;
    }

    public function addModelMail(ModelMail $modelMail): self
    {
        if (!$this->modelMails->contains($modelMail)) {
            $this->modelMails[] = $modelMail;
            $modelMail->setModelMail($this);
        }

        return $this;
    }

    public function removeModelMail(ModelMail $modelMail): self
    {
        if ($this->modelMails->removeElement($modelMail)) {
            // set the owning side to null (unless already changed)
            if ($modelMail->getModelMail() === $this) {
                $modelMail->setModelMail(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LeadMembership[]
     */
    public function getLeadId(): Collection
    {
        return $this->lead_id;
    }

    public function addLeadId(LeadMembership $leadId): self
    {
        if (!$this->lead_id->contains($leadId)) {
            $this->lead_id[] = $leadId;
            $leadId->setUser($this);
        }

        return $this;
    }

    public function removeLeadId(LeadMembership $leadId): self
    {
        if ($this->lead_id->removeElement($leadId)) {
            // set the owning side to null (unless already changed)
            if ($leadId->getUser() === $this) {
                $leadId->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFirstName();
    }

    public function getApiKeyLearnybox(): ?string
    {
        return $this->api_key_learnybox;
    }

    public function setApiKeyLearnybox(?string $api_key_learnybox): self
    {
        $this->api_key_learnybox = $api_key_learnybox;

        return $this;
    }

    public function getSubdomainLearnybox(): ?string
    {
        return $this->subdomain_learnybox;
    }

    public function setSubdomainLearnybox(string $subdomain_learnybox): self
    {
        $this->subdomain_learnybox = $subdomain_learnybox;

        return $this;
    }
}
