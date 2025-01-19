<?php

namespace App\Repository;

use App\Entity\Equipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipe>
 */
class EquipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipe::class);
    }

    /**
     * Retourne toutes les équipes actives
     * (exemple de requête personnalisée).
     *
     * @return Equipe[]
     */
    public function All(): array
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.datesuppression is Null');
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
