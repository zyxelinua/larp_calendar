<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
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
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLatest($numberOfItems)
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.status = :val')
            ->setParameter('val', Event::STATUS_APPROVED)
            ->orderBy('event.publishDate', 'DESC')
            ->setMaxResults($numberOfItems)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return integer
     */
    public function countItems()
    {
        return $this->createQueryBuilder('event')
            ->select('count(event.id)')
            ->andWhere('event.status = :val')
            ->setParameter('val', Event::STATUS_APPROVED)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param $limit
     * @param $offset
     */
    public function findList($limit, $offset)
    {
        return $this->createQueryBuilder('event')
            ->andWhere('event.startDate >= :today')
            ->andWhere('event.status = :val')
            ->setParameters(array('today'=> date('Y-m-d'), 'val' => Event::STATUS_APPROVED))
            ->orderBy('event.startDate', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $limit
     * @param $offset
     */
    public function findListAdmin($limit, $offset)
    {
        return $this->createQueryBuilder('event')
            ->orderBy('event.created', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return integer
     */
    public function countItemsAdmin()
    {
        return $this->createQueryBuilder('event')
            ->select('count(event.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
