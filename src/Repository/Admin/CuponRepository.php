<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Cupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cupon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cupon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cupon[]    findAll()
 * @method Cupon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cupon::class);
    }

    // /**
    //  * @return Cupon[] Returns an array of Cupon objects
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
    public function findOneBySomeField($value): ?Cupon
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
