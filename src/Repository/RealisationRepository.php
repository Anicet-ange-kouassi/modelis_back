<?php

namespace App\Repository;

use App\Entity\Realisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Realisation>
 */
class RealisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Realisation::class);
    }
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.images', 'i')
            ->addSelect('i')
            ->getQuery()
            ->getResult();
    }
}
