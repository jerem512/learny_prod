<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class SaveMemberCpfService
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;        
    }
    
    public function saveMemberCpf($member){
        $entityManager = $this->em;
        $entityManager->persist($member);
        $entityManager->flush();
    }
}