<?php

namespace App\Repository;

use App\Entity\OrderStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderStatut[]    findAll()
 * @method OrderStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderStatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderStatut::class);
    }

    // /**
    //  * @return OrderStatut[] Returns an array of OrderStatut objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderStatut
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
