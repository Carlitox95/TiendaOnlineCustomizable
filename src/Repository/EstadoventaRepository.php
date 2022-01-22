<?php

namespace App\Repository;

use App\Entity\Estadoventa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Estadoventa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estadoventa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estadoventa[]    findAll()
 * @method Estadoventa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoventaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estadoventa::class);
    }

    // /**
    //  * @return Estadoventa[] Returns an array of Estadoventa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Estadoventa
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
