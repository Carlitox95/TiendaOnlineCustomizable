<?php

namespace App\Repository;

use App\Entity\ProductosCarrito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductosCarrito|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductosCarrito|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductosCarrito[]    findAll()
 * @method ProductosCarrito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosCarritoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductosCarrito::class);
    }

    // /**
    //  * @return ProductosCarrito[] Returns an array of ProductosCarrito objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductosCarrito
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
