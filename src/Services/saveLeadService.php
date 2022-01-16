<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class saveLeadService
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;        
    }
    public function saveLead($lead){
        $entityManager = $this->em;
        $entityManager->persist($lead);
        $entityManager->flush();
    }
}