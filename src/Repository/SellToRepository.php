<?php

namespace App\Repository;

use App\Entity\SellTo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SellTo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SellTo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SellTo[]    findAll()
 * @method SellTo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SellToRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SellTo::class);
    }

    // /**
    //  * @return SellTo[] Returns an array of SellTo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SellTo
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
