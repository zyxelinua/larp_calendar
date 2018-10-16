<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AdminEntityRepository extends ServiceEntityRepository
{
    public function findList($limit, $offset)
    {
        return $this->createQueryBuilder('entity')
            ->select('entity')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countItems()
    {
        return $this->createQueryBuilder('entity')
            ->select('count(entity.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
