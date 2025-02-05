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

    /**
     * Retourne toutes les équipes dont le pays a le code spécifié.
     *
     * @param string $countryCode Le code du pays (par exemple "FRA", "MLI", "SEN")
     *
     * @return Equipe[] Retourne un tableau d'objets Equipe
     */
    public function findByCountryCode(string $countryCode): array
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.paysId', 'p')
            ->addSelect('p')
            ->where('p.code = :code')
            ->setParameter('code', $countryCode);

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne toutes les équipes avec leurs relations (par exemple, pays, personnes et leurs profils).
     *
     * @return Equipe[] Retourne un tableau d'objets Equipe
     */
    public function findAllWithRelations(): array
    {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.paysId', 'p')
            ->addSelect('p')
            ->leftJoin('e.personnes', 'pers')
            ->addSelect('pers')
            // Si chaque personne a d'autres relations (comme profil), vous pouvez les joindre :
            ->leftJoin('pers.profil', 'prof')
            ->addSelect('prof');

        return $qb->getQuery()->getResult();
    }
}
