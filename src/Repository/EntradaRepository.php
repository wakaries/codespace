<?php

namespace App\Repository;

use App\Entity\Entrada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Entrada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrada[]    findAll()
 * @method Entrada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrada::class);
    }

    public function getBySlugDql($slug)
    {
        $dql = 'SELECT e FROM App\Entity\Entrada e WHERE e.slug = :slug';
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter('slug', $slug);
        return $query->getOneOrNullResult();
    }

    public function getBySlugQueryBuilder($slug)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.slug = :slug')
            ->setParameter('slug', $slug)
        ;
        return $qb->getQuery()->getOneOrNullResult();
    }

}
