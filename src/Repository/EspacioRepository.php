<?php

namespace App\Repository;

use App\Entity\Espacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Espacio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espacio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espacio[]    findAll()
 * @method Espacio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspacioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espacio::class);
    }

    // /**
    //  * @return Espacio[] Returns an array of Espacio objects
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
    public function findOneBySomeField($value): ?Espacio
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
