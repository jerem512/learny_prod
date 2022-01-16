<?php

namespace App\Repository;

use App\Entity\NotificationsPathLeads;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NotificationsPathLeads|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotificationsPathLeads|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotificationsPathLeads[]    findAll()
 * @method NotificationsPathLeads[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsPathLeadsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationsPathLeads::class);
    }

    // /**
    //  * @return NotificationsPathLeads[] Returns an array of NotificationsPathLeads objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NotificationsPathLeads
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
