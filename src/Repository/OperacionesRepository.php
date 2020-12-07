<?php

namespace App\Repository;

use App\Entity\Operaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operaciones[]    findAll()
 * @method Operaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operaciones::class);
    }

    // /**
    //  * @return Operaciones[] Returns an array of Operaciones objects
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
    public function findOneBySomeField($value): ?Operaciones
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
