<?php

namespace App\Repository;

use App\Entity\Subgenre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subgenre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subgenre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subgenre[]    findAll()
 * @method Subgenre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubgenreRepository extends AdminEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subgenre::class);
    }

//    /**
//     * @return Category[] Returns an array of Category objects
//     */
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
    public function findOneBySomeField($value): ?Category
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
