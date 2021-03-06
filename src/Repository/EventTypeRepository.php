<?php

namespace App\Repository;

use App\Entity\EventType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventType[]    findAll()
 * @method EventType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventTypeRepository extends AdminEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventType::class);
    }

//    /**
//     * @return Type[] Returns an array of Type objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Type
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function createFormQueryBuilder()
    {
        return $this->createQueryBuilder('type')->innerJoin('type.events', 'event');
    }
}
