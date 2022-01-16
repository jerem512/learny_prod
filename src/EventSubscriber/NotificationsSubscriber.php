<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;
use App\Repository\NotifsRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NotificationsSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $notificationsRepository;
    

    public function __construct(Environment $twig, NotifsRepository $notifsRepository)
    {
        $this->twig = $twig;
        $this->notificationsRepository = $notifsRepository;
        
    }


    public function onKernelController(ControllerEvent $event)
    {
        $user = 5;
        $notifications = $this->notificationsRepository->findBy(['user_to' => $user]);
        $this->twig->addGlobal('notifications' , $notifications);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
