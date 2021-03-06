<?php

namespace App\Repository;

use App\Entity\Token;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Token|null find($id, $lockMode = null, $lockVersion = null)
 * @method Token|null findOneBy(array $criteria, array $orderBy = null)
 * @method Token[]    findAll()
 * @method Token[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    public function findOneByToken(string $token)
    {
        $qb = $this->getBaseQueryBuilder();
        self::addTokenClause($qb, $token);

        return $qb->getQuery()
            ->getResult();
    }

    protected function getBaseQueryBuilder()
    {
        return $this->createQueryBuilder("t")
            ->select('t, u')
            ->leftJoin('t.user', 'u');
    }

    static function addTokenClause(QueryBuilder $qb, string $token){
        return $qb->andWhere("t.token = :token")
            ->setParameter('token',$token);
    }
}
