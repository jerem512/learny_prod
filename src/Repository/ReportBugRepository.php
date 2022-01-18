<?php

namespace App\Repository;

use App\Entity\ReportBug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportBug|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportBug|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportBug[]    findAll()
 * @method ReportBug[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportBugRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportBug::class);
    }

    // /**
    //  * @return ReportBug[] Returns an array of ReportBug objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReportBug
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
