<?php

namespace App\Repository;

use App\Entity\Close;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Close|null find($id, $lockMode = null, $lockVersion = null)
 * @method Close|null findOneBy(array $criteria, array $orderBy = null)
 * @method Close[]    findAll()
 * @method Close[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CloseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Close::class);
    }

    public function findByGroup($id)
    {
        $entityManager = $this->getEntityManager();

        $qb = $entityManager->createQuery("SELECT COUNT(c.name) as count, c.name 
        FROM App\Entity\Close c
        WHERE c.user_id = :id
        GROUP BY c.name
        ORDER BY count DESC")
        ->setParameter('id', $id);

        return $qb->getResult();
    }

    // /**
    //  * @return Close[] Returns an array of Close objects
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
    public function findOneBySomeField($value): ?Close
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
