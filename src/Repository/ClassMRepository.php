<?php

namespace App\Repository;

use App\Entity\ClassM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClassM|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassM|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassM[]    findAll()
 * @method ClassM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassMRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassM::class);
    }

    // /**
    //  * @return ClassM[] Returns an array of ClassM objects
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
    public function findOneBySomeField($value): ?ClassM
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
