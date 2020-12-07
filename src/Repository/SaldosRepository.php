<?php

namespace App\Repository;

use App\Entity\Saldos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Saldos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saldos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saldos[]    findAll()
 * @method Saldos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaldosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saldos::class);
    }

    // /**
    //  * @return Saldos[] Returns an array of Saldos objects
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
    public function findOneBySomeField($value): ?Saldos
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
