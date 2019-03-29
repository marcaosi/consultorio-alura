<?php

namespace App\Repository;

use App\Entity\Especialidades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Especialidades|null find($id, $lockMode = null, $lockVersion = null)
 * @method Especialidades|null findOneBy(array $criteria, array $orderBy = null)
 * @method Especialidades[]    findAll()
 * @method Especialidades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspecialidadesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Especialidades::class);
    }

    // /**
    //  * @return Especialidades[] Returns an array of Especialidades objects
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
    public function findOneBySomeField($value): ?Especialidades
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
