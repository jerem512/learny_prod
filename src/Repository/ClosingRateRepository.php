<?php

namespace App\Repository;

use App\Entity\ClosingRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClosingRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClosingRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClosingRate[]    findAll()
 * @method ClosingRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClosingRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClosingRate::class);
    }

    public function drop_table($id_lign){

        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQuery('DELETE FROM App\Entity\ClosingRate c WHERE c.id = :id')
        ->setParameter('id', $id_lign);

        return $qb->getResult();
    }

    // /**
    //  * @return ClosingRate[] Returns an array of ClosingRate objects
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
    public function findOneBySomeField($value): ?ClosingRate
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
