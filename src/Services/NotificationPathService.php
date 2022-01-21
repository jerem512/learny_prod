<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class NotificationPathService
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;        
    }

    public function setNotificationPath($notifications, $notificationType, $notificationTitle, $notificationBody, $notificationCreatedAt, $leadId){

        $notifications->setNotificationType($notificationType);
        $notifications->setNotificationTitle($notificationTitle);
        $notifications->setNotificationBody($notificationBody);
        $notifications->setCreatedAt($notificationCreatedAt);
        $notifications->setLeadId($leadId);

        $entityManager = $this->em;
        $entityManager->persist($notifications);
        $entityManager->flush();  
    }
}