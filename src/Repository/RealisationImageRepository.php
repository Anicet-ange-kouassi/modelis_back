<?php

namespace App\Repository;

use App\Entity\RealisationImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RealisationImage>
 */
class RealisationImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealisationImage::class);
    }

    public function findByRealisationId(int $realisationId): array
    {
        return $this->createQueryBuilder('ri')
            ->andWhere('ri.realisationId = :realisationId')
            ->setParameter('realisationId', $realisationId)
            ->getQuery()
            ->getResult();
    }


    //    public function findOneBySomeField($value): ?RealisationImage
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
