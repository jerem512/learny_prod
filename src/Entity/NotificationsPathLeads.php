<?php

namespace App\Entity;

use App\Repository\NotificationsPathLeadsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationsPathLeadsRepository::class)
 */
class NotificationsPathLeads
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $notification_body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $notification_type;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $notification_title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lead_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotificationBody(): ?string
    {
        return $this->notification_body;
    }

    public function setNotificationBody(string $new_notification): self
    {
        $this->notification_body = $new_notification;

        return $this;
    }

    public function getNotificationType(): ?string
    {
        return $this->notification_type;
    }

    public function setNotificationType(string $notification_type): self
    {
        $this->notification_type = $notification_type;

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

    public function getNotificationTitle(): ?string
    {
        return $this->notification_title;
    }

    public function setNotificationTitle(string $notification_title): self
    {
        $this->notification_title = $notification_title;

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
}
