<?php

namespace App\Repository;

use App\Entity\UserProductHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProductHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProductHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProductHistory[]    findAll()
 * @method UserProductHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProductHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProductHistory::class);
    }

    // /**
    //  * @return UserProductHistory[] Returns an array of UserProductHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserProductHistory
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
