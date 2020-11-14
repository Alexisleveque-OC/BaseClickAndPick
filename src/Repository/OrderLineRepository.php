<?php

namespace App\Repository;

use App\Entity\Meal;
use App\Entity\OrderLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderLine[]    findAll()
 * @method OrderLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderLine::class);
    }

    public function findAllByMeal(Meal $meal)
    {
        $qb = $this->getBaseQueryBuilder();

        self::addMealClause($qb, $meal);

        return $qb->getQuery()
            ->getResult();
    }


    protected function getBaseQueryBuilder()
    {
        return $this->createQueryBuilder("ol")
            ->select('ol')
            ->leftJoin('ol.meal','m');
    }

    protected static function addMealClause(QueryBuilder $qb, Meal $meal){
        return $qb->andWhere('m.id = :mealId')
            ->setParameter('mealId', $meal->getId());
    }
    // /**
    //  * @return OrderLine[] Returns an array of OrderLine objects
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
    public function findOneBySomeField($value): ?OrderLine
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
