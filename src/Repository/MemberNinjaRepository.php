<?php

namespace App\Repository;

use App\Entity\MemberNinja;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberNinja|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberNinja|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberNinja[]    findAll()
 * @method MemberNinja[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberNinjaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberNinja::class);
    }

    public function countMemberNinja()
    {
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQuery("SELECT COUNT(m.id)
                    FROM App\Entity\MemberNinja m
                    ");

        return $qb->getResult();
    }

    // /**
    //  * @return MemberNinja[] Returns an array of MemberNinja objects
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
    public function findOneBySomeField($value): ?MemberNinja
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
