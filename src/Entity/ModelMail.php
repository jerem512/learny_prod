<?php

namespace App\Entity;

use App\Repository\ModelMailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelMailRepository::class)
 */
class ModelMail
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
    private $model_object;

    /**
     * @ORM\Column(type="text")
     */
    private $model_body;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="modelMails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model_mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Type;

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

    public function getModelObject(): ?string
    {
        return $this->model_object;
    }

    public function setModelObject(string $model_object): self
    {
        $this->model_object = $model_object;

        return $this;
    }

    public function getModelBody(): ?string
    {
        return $this->model_body;
    }

    public function setModelBody(string $model_body): self
    {
        $this->model_body = $model_body;

        return $this;
    }

    public function getModelMail(): ?Users
    {
        return $this->model_mail;
    }

    public function setModelMail(?Users $model_mail): self
    {
        $this->model_mail = $model_mail;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
}
