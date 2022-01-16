<?php

namespace App\Repository;

use App\Entity\ModelMail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModelMail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModelMail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModelMail[]    findAll()
 * @method ModelMail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelMailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModelMail::class);
    }

    // /**
    //  * @return ModelMail[] Returns an array of ModelMail objects
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
    public function findOneBySomeField($value): ?ModelMail
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
