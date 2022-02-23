<?php

namespace App\Repository;

use App\Entity\MemberPack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberPack|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberPack|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberPack[]    findAll()
 * @method MemberPack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberPackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberPack::class);
    }

    // /**
    //  * @return MemberPack[] Returns an array of MemberPack objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemberPack
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
