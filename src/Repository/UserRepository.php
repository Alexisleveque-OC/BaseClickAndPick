<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneById(string $token)
    {
        $qb = $this->getBaseQueryBuilder();
        self::addIdClause($qb, $token);

        return $qb->getQuery()
            ->getResult();
    }

    public function findOneByEmail(string $email)
    {
        $qb = $this->getBaseQueryBuilder();
        self::addEmailClause($qb, $email);

        return $qb->getQuery()
            ->getResult();
    }

    protected function getBaseQueryBuilder()
    {
        return $this->createQueryBuilder("u")
            ->select('u');
    }

    static function addIdClause(QueryBuilder $qb, int $id){
        return $qb->andWhere("u.id = :id")
            ->setParameter('id',$id);
    }
    static function addEmailClause(QueryBuilder $qb, string $email){
        return $qb->andWhere("u.email = :email")
            ->setParameter('email',$email);
    }
}
