<?php

namespace App\Repository;

use App\Entity\LeadMembership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LeadMembership|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeadMembership|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeadMembership[]    findAll()
 * @method LeadMembership[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeadMembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LeadMembership::class);
    }

    // /**
    //  * @return LeadMembership[] Returns an array of LeadMembership objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LeadMembership
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
