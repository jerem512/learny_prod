<?php

namespace App\Repository;

use App\Entity\ClosingRateBackup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClosingRateBackup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClosingRateBackup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClosingRateBackup[]    findAll()
 * @method ClosingRateBackup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClosingRateBackupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClosingRateBackup::class);
    }

    // /**
    //  * @return ClosingRateBackup[] Returns an array of ClosingRateBackup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClosingRateBackup
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
