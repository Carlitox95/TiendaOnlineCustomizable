<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    //Funcion que me retorna los productos Disponibles de stock y activos
    public function findByProductosDisponibles() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.activo = 1 and p.stock > 0')            
            ->orderBy('p.id', 'DESC')           
            ->getQuery()
            ->getResult()
        ;
    }
    
    //Funcion que me retorna los productos Destacados que esten activos y tengan stock
    public function findByProductosDestacados() {
        return $this->createQueryBuilder('p')
            ->andWhere('p.activo = 1 and p.stock > 0 and p.destacado = 1')            
            ->orderBy('p.destacado', 'DESC')           
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Producto
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
